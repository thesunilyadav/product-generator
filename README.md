# Product Generator

It generates product csv file for various platforms like Shopify, BigCommerce etc. Simple and easy to use.

## Usage

- Run `composer require sunilyadav/generator`

	- This will add package to your project

- Run `php artisan generator:publish`

	- It publishes route and controller

- That's it, hit the below route and file will be downloaded.

	- For Shopify: `/shopify/get-products`
	- For Bigcommerce: `/bigcommerce/get-products`  


![Screenshot from 2022-05-11 22-37-08](https://user-images.githubusercontent.com/72142357/167909609-f85cfd49-44fa-4dc2-b5d9-6dc637e9a704.png)

## More

> By default it genrates csv file for 10 products.

If you want to genrate more products than pass parameter `products` in query params with number of product value.

> Example : /shopify/get-products?products=100

![Screenshot from 2022-05-11 22-29-22](https://user-images.githubusercontent.com/72142357/167909716-b8705e6c-d249-4b1a-861e-6a914d41814f.png)

## Features
- Generate upto 50000 products

- Upto 27 variants

- Multi Platforms (Shopify, BigCommerce, etc.)

- Multiple options like Color, Size and Material

- Multiple images for single product

- Fast, Simple and easy to use

## Note

Currently this package support product generation for the shopify and bigcommerce. For other platforms, new update will come soon. Stay Connected

# Licence

MIT