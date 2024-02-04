<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  var my_handlers = {
        // fill province
        fill_provinces: function() {
            //selected region
            var region_code = $(this).val();

            // set selected text to input
            var region_text = $(this).find("option:selected").text();
            let region_input = $("#region-text");
            $("#region-txt").text(region_text);
            region_input.val(region_text);
            //clear province & city & barangay input
            $("#province-text").val("");
            $("#city-text").val("");
            $("#barangay-text").val("");

            //province
            let dropdown = $("#province");
            dropdown.empty();
            dropdown.append(
                '<option selected="true" disabled>Choose State/Province</option>'
            );
            dropdown.prop("selectedIndex", 0);

            //city
            let city = $("#city");
            city.empty();
            city.append('<option selected="true" disabled></option>');
            city.prop("selectedIndex", 0);

            //barangay
            let barangay = $("#barangay");
            barangay.empty();
            barangay.append('<option selected="true" disabled></option>');
            barangay.prop("selectedIndex", 0);

            // filter & fill
            var url = "../assets/js/ph-json/province.json";
            $.getJSON(url, function(data) {
                var result = data.filter(function(value) {
                    return value.region_code == region_code;
                });

                result.sort(function(a, b) {
                    return a.province_name.localeCompare(b.province_name);
                });

                $.each(result, function(key, entry) {
                    dropdown.append(
                        $("<option></option>")
                        .attr("value", entry.province_code)
                        .text(entry.province_name)
                    );
                });
            });
        },
        // fill city
        fill_cities: function() {
            //selected province
            var province_code = $(this).val();

            // set selected text to input
            var province_text = $(this).find("option:selected").text();
            let province_input = $("#province-text");
            province_input.val(province_text);
            $("#province-txt").text(province_text);
            //clear city & barangay input
            $("#city-text").val("");
            $("#barangay-text").val("");

            //city
            let dropdown = $("#city");
            dropdown.empty();
            dropdown.append(
                '<option selected="true" disabled>Choose city/municipality</option>'
            );
            dropdown.prop("selectedIndex", 0);

            //barangay
            let barangay = $("#barangay");
            barangay.empty();
            barangay.append('<option selected="true" disabled></option>');
            barangay.prop("selectedIndex", 0);

            // filter & fill
            var url = "../assets/js/ph-json/city.json";
            $.getJSON(url, function(data) {
                var result = data.filter(function(value) {
                    return value.province_code == province_code;
                });

                result.sort(function(a, b) {
                    return a.city_name.localeCompare(b.city_name);
                });

                $.each(result, function(key, entry) {
                    dropdown.append(
                        $("<option></option>")
                        .attr("value", entry.city_code)
                        .text(entry.city_name)
                    );
                });
            });
        },
        // fill barangay
        fill_barangays: function() {
            // selected barangay
            var city_code = $(this).val();

            // set selected text to input
            var city_text = $(this).find("option:selected").text();
            let city_input = $("#city-text");
            city_input.val(city_text);
            $("#city-txt").text(city_text);
            //clear barangay input
            $("#barangay-text").val("");

            // barangay
            let dropdown = $("#barangay");
            dropdown.empty();
            dropdown.append(
                '<option selected="true" disabled>Choose barangay</option>'
            );
            dropdown.prop("selectedIndex", 0);

            // filter & Fill
            var url = "../assets/js/ph-json/barangay.json";
            $.getJSON(url, function(data) {
                var result = data.filter(function(value) {
                    return value.city_code == city_code;
                });

                result.sort(function(a, b) {
                    return a.brgy_name.localeCompare(b.brgy_name);
                });

                $.each(result, function(key, entry) {
                    dropdown.append(
                        $("<option></option>")
                        .attr("value", entry.brgy_code)
                        .text(entry.brgy_name)
                    );
                });
            });
        },

        onchange_barangay: function() {
            var barangay_text = $("#barangay option:selected").text();
            let barangay_input = $("#barangay-text");
            barangay_input.val(barangay_text);
            // Set the selected text to the span
            $("#barangay-txt").text(barangay_text);
            // Show the span element
            $("#barangay-txt").show();
        },
    };

    $(function() {
        // events
        $("#region").on("change", my_handlers.fill_provinces);
        $("#province").on("change", my_handlers.fill_cities);
        $("#city").on("change", my_handlers.fill_barangays);
        $("#barangay").on("change", my_handlers.onchange_barangay);

        var selectedRegionCode = "<?= $regionCode ?>";
        var selectedProvinceCode = "<?= $provinceCode ?>";
        var selectedCityCode = "<?= $cityCode ?>";
        var selectedBarangayCode = "<?= $barangayCode ?>";

        //! Load REGION
        let regionDropdown = $("#region");
        regionDropdown.empty();
        regionDropdown.append(
            '<option selected="true" disabled>Choose Region</option>'
        );
        regionDropdown.prop("selectedIndex", 0);
        const regionUrl = "../assets/js/ph-json/region.json";

        //! Populate dropdown with list of REGION
        $.getJSON(regionUrl, function(data) {
            $.each(data, function(key, entry) {
                regionDropdown.append(
                    $("<option></option>")
                    .attr("value", entry.region_code)
                    .text(entry.region_name)
                );
            });

            //! Set the selected region
            regionDropdown.val(selectedRegionCode);

            //! Trigger change event to fill provinces based on the selected region
            regionDropdown.change();
        });

        //+ Load provinces based on the selected region
        var provinceDropdown = $("#province");
        provinceDropdown.empty();
        provinceDropdown.append('<option selected="true" disabled>Choose State/Province</option>');
        provinceDropdown.prop("selectedIndex", 0);
        const provinceUrl = "../assets/js/ph-json/province.json";

        //+ Populate dropdown with list of provinces based on the selected region
        $.getJSON(provinceUrl, function(data) {
            var result = data.filter(function(value) {
                return value.region_code == selectedRegionCode;
            });

            result.sort(function(a, b) {
                return a.province_name.localeCompare(b.province_name);
            });

            $.each(result, function(key, entry) {
                provinceDropdown.append(
                    $("<option></option>")
                    .attr("value", entry.province_code)
                    .text(entry.province_name)
                );
            });

            //+ Set the selected province
            provinceDropdown.val(selectedProvinceCode);

            //+ Trigger change event to fill cities based on the selected province
            provinceDropdown.change();
        });

        //? Load cities based on the selected province
        var cityDropdown = $("#city");
        cityDropdown.empty();
        cityDropdown.append('<option selected="true" disabled>Choose City/Municipality</option>');
        cityDropdown.prop("selectedIndex", 0);
        const cityUrl = "../assets/js/ph-json/city.json";

        //? Populate dropdown with list of cities based on the selected province
        $.getJSON(cityUrl, function(data) {
            var result = data.filter(function(value) {
                return value.province_code == selectedProvinceCode;
            });

            result.sort(function(a, b) {
                return a.city_name.localeCompare(b.city_name);
            });

            $.each(result, function(key, entry) {
                cityDropdown.append(
                    $("<option></option>")
                    .attr("value", entry.city_code)
                    .text(entry.city_name)
                );
            });

            //? Set the selected city
            cityDropdown.val(selectedCityCode);

            //? Trigger change event to fill barangays based on the selected city
            cityDropdown.change();
        });

        //* Load barangays based on the selected city
        var barangayDropdown = $("#barangay");
        barangayDropdown.empty();
        barangayDropdown.append('<option selected="true" disabled>Choose Barangay</option>');
        barangayDropdown.prop("selectedIndex", 0);
        const barangayUrl = "../assets/js/ph-json/barangay.json";

        //* Populate dropdown with list of barangays based on the selected city
        $.getJSON(barangayUrl, function(data) {
            var result = data.filter(function(value) {
                return value.city_code == selectedCityCode;
            });

            result.sort(function(a, b) {
                return a.brgy_name.localeCompare(b.brgy_name);
            });

            $.each(result, function(key, entry) {
                barangayDropdown.append(
                    $("<option></option>")
                    .attr("value", entry.brgy_code)
                    .text(entry.brgy_name)
                );
            });

            //* Set the selected barangay
            barangayDropdown.val(selectedBarangayCode);

            // Trigger the change event manually to update the span initially
            barangayDropdown.change();
        });

    });
</script>