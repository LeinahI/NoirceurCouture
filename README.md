# NoirceurCouture
![NoirceurCouture](https://github.com/LeinahI/NoirceurCouture/assets/53577436/04d31568-5d84-4ba2-a2f0-bf95d0ed596c)

[![Leinah](https://custom-icon-badges.demolab.com/badge/made%20by%20-Leinah-556bf2?logo=github&logoColor=white&labelColor=101827)](https://github.com/LeinahI)
[![License](https://img.shields.io/github/license/LeinahI/NoirceurCouture?color=dddddd&labelColor=000000)](https://github.com/LeinahI/NoirceurCouture/blob/main/LICENSE)
[![Top Language](https://img.shields.io/github/languages/top/LeinahI/NoirceurCouture?logo=php&logoColor=&label=PHP)](#)

## 📝 Description
Customers can enjoy an easy, safe, and fast shopping experience at NoirceurCouture. Customers are able to find and buy the goods they need on our platform, which connects buyers and sellers in a seamless and efficient way. We offer a platform for C2C transactions, enabling users to sell their own goods and increase their customer base. Our user-friendly platform gives sellers everything they need to keep up with their listings and connect with potential customers.


## 🏗 Application Structure
<details><summary><b>Folder Structure</b></summary>
  
```
NoirceurCouture
├─ admin
│  ├─ assets
│  │  ├─ css
│  │  └─ js
│  ├─ models
│  ├─ partials
├─ assets
│  ├─ css
│  ├─ images
│  │  ├─ index
│  │  └─ logo
│  ├─ js
│  └─ uploads
│     ├─ brands
│     ├─ products
│     └─ slideshow
├─ middleware
├─ models
├─ partials
├─ seller
│  ├─ assets
│  │  ├─ css
│  │  └─ js
│  ├─ models
│  ├─ partials
└─ views
```
</details>

## ✨ Technologies Used
<details><summary><b>NoirceurCouture</b> is built using the following technologies:</summary>

- [PHP](https://www.php.net/): PHP is a server-side scripting language to create webpages.
- [Bootstrap](https://getbootstrap.com/docs/5.3/getting-started/introduction/): Boostrap is a CSS Framework for developing responsive webpages.
- [Fontawesome](https://fontawesome.com/): Fontawesome provides SVG icons that can instantly be customized.
- [Materialize CSS](https://materializecss.com/): Materialize CSS is a design language that combines the classic principles of successful design.
- [jQuery](https://jquery.com/): jQuery is a fast, small, and feature-rich JavaScript library. It makes things like HTML document traversal and manipulation, event handling, animation, and Ajax much simpler with an easy-to-use API
- [Paypal Checkout](https://developer.paypal.com/home): Paypal Checkout provides a Payment Gateway for the vital purpose of the online shopping.

</details><br/>

## 📋 License
**NoirceurCouture** is open source software [licensed as MIT](https://opensource.org/license/mit/) and is free to use — See [LICENSE](https://github.com/LeinahI/NoirceurCouture/blob/master/LICENSE) for more details.

## 🔗 Helpful Links of how I develop it
- [PayPal Checkout Javascript function](https://stackoverflow.com/questions/56414640/paypal-checkout-javascript-with-smart-payment-buttons-create-order-problem)
- [Realtime Colors](https://www.realtimecolors.com/?colors=171412-f6ede7-E7DED8-7B7774-bb6c54&fonts=Raleway-Raleway)
- [e-commerce inspiration](https://dribbble.com/shots/22737212-Fashion-E-commerce-Website)

## 🛠 TODO for Noirceur Couture 2.0
Admin Role
- ✅ At dashboard will track the total of buyer, sellers, users, account deleted, & banned users. 
- ✅ Cannot be a seller anymore.
- ✅ Cannot add, edit, and delete stores, products & users of buyer & seller.
- ✅ Admin task is only to moderate the stores, products, users, & seller application. 
- ✅ Admin can ban(permanent) users & sellers.
- ✅ Account Deletion Request form added on Admin UI.
- ✅ Admin can accept and reject user account deletion request.

Buyer Role
- Buyer can have multiple addresses and set which is default address.
- ✅ Buyer can request account deletion.
- Buyer have now notification tab that can see order and Noirceur Couture Updates.
- Buyer can rate products.
- ✅ Can cancel order when the order are preparing to ship.
- ✅ Can set the order status to Delivered. 

Seller Role
- ✅ Seller can set their status on vacation that the buyer cannot add to card and confirm checkout.
- ✅ Seller can request to delete account.
- ✅ Seller cannot set the parcel is delivered anymore.

Buyer UI Changes
- ✅ Dynamic Philippine Address Selector via json
- 🚧 on store.php?category=... It will show the profile and ratings, products, and date joined.
- ✅ myAddress.php will have multiple cards for multiple address.
- On myOrders.php they will separate the orders when user ordered on two or multiple different stores.
- on checkOut.php user can choose which adress they use to deliver the parcel and add new address.
