# Product Generator

It generates product csv file for various platforms like Shopify, BigCommerce etc. Simple and easy to use.

## Usage

 - Run  `composer require sunilyadav/generator`
	 - This will add package to your project
 - Run `php artisan generator:publish`
	 - It publishes route and controller  
- That's it, hit the route to get products.
	- For Shopify: `/shopify/get-products`

## More

> By default it genrates csv file for 10 products.

If you want to genrate more products than pass parameter `products` in query params with number of product value.

> Example : /shopify/get-products?products=100


## Note
 Currently this package support product generation for the shopify. For other platforms, new update will come soon.

# Licence
MIT