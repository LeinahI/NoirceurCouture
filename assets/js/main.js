$(document).ready(function () {
  /* Increment QTY Function */
  /* Increment QTY Function */
  $(".incrementProductBtn").click(function (e) {
    e.preventDefault();

    var inputQty = $(this).closest(".input-group").find(".inputQty");
    var productQty = parseInt(inputQty.val());
    var productPrice = parseFloat(inputQty.data("price"));
    var remainingItems = parseInt(inputQty.data("remain"));

    if (productQty < remainingItems) {
      productQty++;
      inputQty.val(productQty);
    }

    var totalPrice = productPrice * productQty;

    // Update the product price
    $(this)
      .closest(".productData")
      .find(".productPrice")
      .text(formatPrice(totalPrice));

    // Update the overall price
    updateOverallPrice();
  });

  /* Decrement QTY Function */
  $(".decrementProductBtn").click(function (e) {
    e.preventDefault();

    var inputQty = $(this).closest(".input-group").find(".inputQty");
    var productQty = parseInt(inputQty.val());
    var productPrice = parseFloat(inputQty.data("price"));

    if (productQty > 1) {
      productQty--;
      inputQty.val(productQty);
    }

    var totalPrice = productPrice * productQty;

    // Update the product price
    $(this)
      .closest(".productData")
      .find(".productPrice")
      .text(formatPrice(totalPrice));

    // Update the overall price
    updateOverallPrice();
  });

  function formatPrice(price) {
    return price.toLocaleString("en-PH", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });
  }

  function updateOverallPrice() {
    var total = 0;

    $(".productPrice").each(function () {
      var price = parseFloat($(this).text().replace("₱", "").replace(",", ""));
      total += price;
    });

    // Update the overall price in the HTML
    $(".overallPrice").text(formatPrice(total));
  }

  /* Input QTY function */
  $(".inputQty").change(function () {
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

  /* Add to Cart function */
  $(".addToCartBtn").click(function (e) {
    e.preventDefault();

    var prod_qty = parseInt(
      $(this).closest(".productData").find(".inputQty").val(),
      10
    );
    var prod_rmn = parseInt(
      $(this).closest(".productData").find(".prodRmn").text(),
      10
    );
    var prod_slug = $(this).closest(".productData").find(".product_link").val();
    var categ_id = $(this).closest(".productData").find(".categID").val();
    var prod_id = $(this).val();

    $.ajax({
      method: "POST",
      url: "/NoirceurCouture/models/handleCart.php",
      data: {
        product_id: prod_id,
        product_qty: prod_qty,
        product_rmn: prod_rmn,
        product_slug: prod_slug,
        category_id: categ_id,
        scope: "add",
      },
      success: function (response) {
        if (response == 201) {
          updateCartItemsOnAdd();
          swal({
            title: "Product added to cart",
            icon: "success",
            button: "OK",
          });
        } else if (response == "existing") {
          swal({
            title: "Product already in your cart",
            icon: "error",
            button: "OK",
          });
        } else if (response == "soldout") {
          swal({
            title: "Product is already Sold out",
            icon: "error",
            button: "OK",
          });
        } else if (response == "qtyerr") {
          swal({
            title: "Order Quantity is higher than remaining item",
            icon: "error",
            button: "OK",
          });
        } else if (response == 401) {
          swal({
            title: "Log in to continue",
            icon: "error",
            button: "OK",
          }).then(() => {
            // Navigate to another page
            window.location.href = "login.php";
          });
        } else if (response == 500) {
          swal({
            title: "Something went wrong",
            icon: "error",
            button: "OK",
          });
        }
      },
    });
  });

  /* Update cart qty */
  function updateCartItemsOnAdd() {
    var productViewContainer = $("#productView");

    // Clear the existing content inside the .cart-items container
    productViewContainer.empty();

    // Reload the content inside the .cart-items container
    $.ajax({
      url: "#", // Replace with the actual file path
      success: function (newContent) {
        productViewContainer.html(newContent);
      },
    });
  }

  /* Update item QTY cart function that display on C */
  $(document).on("click", ".updateQty", function (e) {
    var prod_qty = $(this).closest(".productData").find(".inputQty").val();
    var prod_id = $(this).closest(".productData").find(".productID").val();

    $.ajax({
      type: "POST",
      url: "/NoirceurCouture/models/handleCart.php",
      data: {
        product_id: prod_id,
        product_qty: prod_qty,
        scope: "update",
      },
      success: function (response) {},
    });
  });

  /* Delete Item Cart function */
  $(document).on("click", ".deleteItem", function (e) {
    var cart_id = $(this).val();

    $.ajax({
      type: "POST",
      url: "/NoirceurCouture/models/handleCart.php",
      data: {
        cart_id: cart_id,
        scope: "delete",
      },
      success: function (response) {
        if (response == 200) {
          updateCartItemsOnDelete();
        } else {
          /* swal({
            title: response,
            icon: "error",
            button: "OK",
          }); */
        }
      },
    });
  });

  /* Update Cart Items */
  function updateCartItemsOnDelete() {
    var cartItemsContainer = $("#mycart");

    // Clear the existing content inside the .cart-items container
    cartItemsContainer.empty();

    // Reload the content inside the .cart-items container
    $.ajax({
      type: "GET",
      url: "#", // Replace with the actual file path
      success: function (newContent) {
        cartItemsContainer.html(newContent);
      },
    });
  }

  /* Add item to Likes function */
  $(".addToLikesBtn").click(function (e) {
    e.preventDefault();

    var prod_slug = $(this).closest(".productData").find(".product_link").val();
    var prod_id = $(this).val();

    $.ajax({
      method: "POST",
      url: "/NoirceurCouture/models/handleLikes.php",
      data: {
        product_id: prod_id,
        product_slug: prod_slug,
        scope: "addLikes",
      },
      success: function (response) {
        if (response == 201) {
          updateLikeItemsOnAdd();
          /* swal({
            title: "Product added to Likes",
            icon: "success",
            button: "OK",
          }); */
        } else if (response == "existing") {
          swal({
            title: "Product already in your Likes",
            icon: "error",
            button: "OK",
          });
        } else if (response == 401) {
          swal({
            title: "Log in to continue",
            icon: "error",
            button: "OK",
          }).then(() => {
            // Navigate to another page
            window.location.href = "login.php";
          });
        } else if (response == 500) {
          swal({
            title: "Something went wrong",
            icon: "error",
            button: "OK",
          });
        }
      },
    });
  });

  /* Update cart qty */
  function updateLikeItemsOnAdd() {
    var productViewContainer = $("#productView");

    // Clear the existing content inside the .cart-items container
    productViewContainer.empty();

    // Reload the content inside the .cart-items container
    $.ajax({
      url: "#", // Replace with the actual file path
      success: function (newContent) {
        productViewContainer.html(newContent);
      },
    });
  }

  /* Delete Item Like function */
  $(document).on("click", ".deleteItemLike", function (e) {
    var cart_id = $(this).val();

    $.ajax({
      type: "POST",
      url: "/NoirceurCouture/models/handleLikes.php",
      data: {
        cart_id: cart_id,
        scope: "deleteLike",
      },
      success: function (response) {
        if (response == 200) {
          $("#mylikes").load(location.href + " #mylikes");
        } else {
          swal({
            title: response,
            icon: "error",
            button: "OK",
          });
        }
      },
    });
  });

  
});
