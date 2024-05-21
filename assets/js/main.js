$(document).ready(function () {
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
      var price = parseFloat(
        $(this).text().replace("₱", "").replace(",", "").replace(",", "")
      );
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

  //!--------------Add and Delete item to Cart----------------
  //* Add to Cart function
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
          /*  updateCartItemsOnAdd(); */
          updateCartQty();
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

  //* Update cart QTY
  function updateCartQty() {
    $.ajax({
      url: "/NoirceurCouture/models/getCartQty.php",
      method: "GET",
      success: function (response) {
        console.log("Cart quantity response:", response); // Log the response for debugging
        if (response.cartQty !== undefined) {
          $("#itemCartQty").text(response.cartQty);
        } else {
          console.error("cartQty is undefined in the response");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error fetching cart quantity: " + error);
      },
    });
  }

  //* Update item QTY cart function that display on productView & myCart
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

  //* Check if there are any items in the cart initially
  checkCartItems();

  $(document).on("click", "#deleteItem", function (e) {
    e.preventDefault(); // Prevent default action if it's a button or link

    var cart_id = $(this).val(); // Get the cart ID from the clicked button's value
    var $productToDelete = $(this).closest("#productList"); // Find the closest parent element with the ID 'productList' from the clicked button
    var $itemsContainer = $productToDelete.closest("#itemsContainer"); // Find the closest parent element with the ID 'itemsContainer' from the product to delete
    var $categoryCard = $itemsContainer.closest("#categoryCard"); // Find the closest parent element with the ID 'categoryCard' from the items container

    // Make an AJAX POST request to handleCart.php to delete the item
    $.ajax({
      type: "POST",
      url: "/NoirceurCouture/models/handleCart.php",
      data: {
        cart_id: cart_id, // Send the cart ID
        scope: "delete", // Specify the scope as 'delete'
      },
      success: function (response) {
        // If the response indicates success (status 200)
        if (response == 200) {
          // Fade out the product to delete over 300ms
          $productToDelete.fadeOut(300, function () {
            $(this).remove(); // Remove the product from the DOM after fading out

            // Check if the items container is empty
            if ($itemsContainer.children().length === 0) {
              // If empty, fade out the category card over 300ms
              $categoryCard.fadeOut(300, function () {
                $(this).remove(); // Remove the category card from the DOM after fading out
                checkCartItems(); // Check the cart items to update the visibility of the empty cart message
              });
            } else {
              checkCartItems(); // If the items container is not empty, just check the cart items
            }

            // Update the cart quantity
            updateMyCartQty();
            updateOverallPrice();
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error: " + status + " - " + error);
      },
    });
  });

  function updateMyCartQty() {
    $.ajax({
      url: "/NoirceurCouture/models/getCartQty.php",
      method: "GET",
      success: function (response) {
        if (response.cartQty !== undefined) {
          $("#productCountSide").text(response.cartQty);
          $("#productCountBottom").text(response.cartQty);

        }
      },
      error: function (xhr, status, error) {
        console.error("Error fetching cart quantity: " + error);
      },
    });
  }

  function checkCartItems() {
    var isExist = $("#categoryCard").length > 0; // Check if there are any elements with the ID 'categoryCard'
    if (isExist) {
      $("#nocartItems").hide();
    } else {
      $("#nocartItems").show();
    }
  }

  //!--------------Add and Delete item to Wishlist----------------
  //* Add to wishlist function
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
          updateLikeQty();
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

  //* Update like QTY
  function updateLikeQty() {
    $.ajax({
      url: "/NoirceurCouture/models/getLikeQty.php",
      method: "GET",
      success: function (response) {
        if (response.likeQty !== undefined) {
          $("#itemLikeQty").text(response.likeQty);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error fetching like quantity: " + error);
      },
    });
  }

  checkLikedItems();

  //* AJAX call to delete wishlist item
  $(document).on("click", "#deleteItemLike", function (e) {
    var like_id = $(this).val();
    var $itemToDelete = $(this).closest(".card");

    $.ajax({
      type: "POST",
      url: "/NoirceurCouture/models/handleLikes.php",
      data: {
        like_id: like_id,
        scope: "deleteLike",
      },
      success: function (response) {
        if (response == 200) {
          $itemToDelete.fadeOut(300, function () {
            $(this).remove(); // Remove the deleted item from the DOM
            checkLikedItems();
          });
        } else {
          swal({
            title: response,
            icon: "error",
            button: "OK",
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("Error deleting item from Likes: " + error);
      },
    });
  });

  //* Function to check wishlist items using AJAX
  function checkLikedItems() {
    $.ajax({
      url: "/NoirceurCouture/models/checkLikedItems.php", // PHP script to check liked items
      type: "GET",
      success: function (response) {
        if (parseInt(response) > 0) {
          $("#noLikedItems").hide();
        } else {
          $("#noLikedItems").show();
        }
      },
    });
  }
});
