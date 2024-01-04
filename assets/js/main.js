$(document).ready(function () {
    $('.incrementProductBtn').click(function (e) {
        e.preventDefault();

        var inputQty = $(this).closest('.input-group').find('.inputQty');
        var productQty = parseInt(inputQty.val());
        var productPrice = parseFloat(inputQty.data('price'));

        if (productQty < 3) {
            productQty++;
            inputQty.val(productQty);
        }

        var totalPrice = productPrice * productQty;
        var formattedPrice = '₱' + totalPrice.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        $(this).closest('.productData').find('.productPrice').text(formattedPrice);
    });

    $('.decrementProductBtn').click(function (e) {
        e.preventDefault();

        var inputQty = $(this).closest('.input-group').find('.inputQty');
        var productQty = parseInt(inputQty.val());
        var productPrice = parseFloat(inputQty.data('price'));

        if (productQty > 1) {
            productQty--;
            inputQty.val(productQty);
        }

        var totalPrice = productPrice * productQty;
        var formattedPrice = '₱' + totalPrice.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        $(this).closest('.productData').find('.productPrice').text(formattedPrice);
    });

    $('.inputQty').change(function () {
        var qty = $(this).val();
        var value = parseInt(qty, 10);
        value = isNaN(value) ? 0 : value;

        if (value > 3) {
            value = 3;
        } else if (value < 1) {
            value = 1;
        }

        $(this).val(value);
    });

    $('.addToCartBtn').click(function (e) {
        e.preventDefault();

        var prod_qty = $(this).closest('.productData').find('.inputQty').val();
        var prod_slug = $(this).closest('.productData').find('.product_link').val();
        var prod_id = $(this).val();

        $.ajax({
            method: "POST",
            url: "/NoirceurCouture/models/handleCart.php",
            data: {
                "product_id": prod_id,
                "product_qty": prod_qty,
                "product_slug": prod_slug,
                "scope": "add"
            },
            success: function (response) {
                if (response == 201) {
                    swal({
                        title: "Product added to cart",
                        icon: "success",
                        button: 'OK',
                    });
                } else if (response == "existing") {
                    swal({
                        title: "Product already in your cart",
                        icon: "error",
                        button: 'OK',
                    });
                }
                else if (response == 401) {
                    swal({
                        title: "Log in to continue",
                        icon: "error",
                        button: 'OK',
                    }).then(() => {
                        // Navigate to another page
                        window.location.href = "login.php";
                    });
                }
                else if (response == 500) {
                    swal({
                        title: "Something went wrong",
                        icon: "error",
                        button: 'OK',
                    });
                }
            }
        });
    });

    $(document).on('click', '.updateQty', function (e) {
        var prod_qty = $(this).closest('.productData').find('.inputQty').val();
        var prod_id = $(this).closest('.productData').find('.productID').val();

        $.ajax({
            type: "POST",
            url: "/NoirceurCouture/models/handleCart.php",
            data: {
                "product_id": prod_id,
                "product_qty": prod_qty,
                "scope": "update"
            },
            success: function (response) {

            }
        });
    });

    $(document).on('click', '.deleteItem', function (e) {
        var cart_id = $(this).val();

        $.ajax({
            type: "POST",
            url: "/NoirceurCouture/models/handleCart.php",
            data: {
                "cart_id": cart_id,
                "scope": "delete"
            },
            success: function (response) {
                if (response == 200) {
                    swal({
                        title: "Product deleted successfully",
                        icon: "success",
                        button: 'OK',
                    });
                    $('#mycart').load(location.href + " #mycart");
                } else {
                    swal({
                        title: response,
                        icon: "error",
                        button: 'OK',
                    });
                }
            }
        });
    });

    $('.addToLikesBtn').click(function (e) {
        e.preventDefault();

        var prod_slug = $(this).closest('.productData').find('.product_link').val();
        var prod_id = $(this).val();

        $.ajax({
            method: "POST",
            url: "/NoirceurCouture/models/handleLikes.php",
            data: {
                "product_id": prod_id,
                "product_slug": prod_slug,
                "scope": "addLikes"
            },
            success: function (response) {
                if (response == 201) {
                    swal({
                        title: "Product added to Likes",
                        icon: "success",
                        button: 'OK',
                    });
                } else if (response == "existing") {
                    swal({
                        title: "Product already in your Likes",
                        icon: "error",
                        button: 'OK',
                    });
                }
                else if (response == 401) {
                    swal({
                        title: "Log in to continue",
                        icon: "error",
                        button: 'OK',
                    }).then(() => {
                        // Navigate to another page
                        window.location.href = "login.php";
                    });
                }
                else if (response == 500) {
                    swal({
                        title: "Something went wrong",
                        icon: "error",
                        button: 'OK',
                    });
                }
            }
        });
    });

    $(document).on('click', '.deleteItemLike', function (e) {
        var cart_id = $(this).val();

        $.ajax({
            type: "POST",
            url: "/NoirceurCouture/models/handleLikes.php",
            data: {
                "cart_id": cart_id,
                "scope": "deleteLike"
            },
            success: function (response) {
                if (response == 200) {
                    swal({
                        title: "Product unliked successfully",
                        icon: "success",
                        button: 'OK',
                    });
                    $('#mylikes').load(location.href + " #mylikes");
                } else {
                    swal({
                        title: response,
                        icon: "error",
                        button: 'OK',
                    });
                }
            }
        });
    });

});
