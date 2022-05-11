<?php

namespace Sunilyadav\Generator\Platforms;

use Faker\Factory;
use Response;
use File;
use Illuminate\Support\Str;

class ShopifyGenerator
{

    /**
     * Generate product csv file
     * 
     * @param int $numberOfProduct
     * 
     * @return mixed
     */
    public function getFile($numberOfProduct)
    {
        $faker = Factory::create();

        // these are the headers for the csv file.
        $headers = array(
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=download.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        );


        //I am storing the csv file in public >> files folder. So that why I am creating files folder
        if (!File::exists(public_path() . "/files")) {
            File::makeDirectory(public_path() . "/files");
        }

        //creating the download file
        $filename =  public_path("files/download.csv");
        $handle = fopen($filename, 'w');

        //adding the first row
        fputcsv($handle, [
            "Handle",
            "Title",
            "Body (HTML)",
            "Vendor",
            "Standardized Product Type",
            "Tags",
            "Published",

            "Option1 Name",
            "Option1 Value",
            "Option2 Name",
            "Option2 Value",
            "Option3 Name",
            "Option3 Value",

            "Variant SKU",
            "Variant Grams",
            'Variant Weight Unit',
            'Variant Inventory Qty',
            'Variant Inventory Policy',
            'Variant Fulfillment Service',
            'Variant Price',
            'Variant Compare At Price',
            'Variant Requires Shipping',
            'Variant Taxable',

            "Image Src",
            "Image Position",
            "Image Alt Text",

            "Status"
        ]);

        $StandardizedProductType = ["Arts & Entertainment", "Baby & Toddler", "Cameras & Optics", "Apparel & Accessories", "Electronics", "Luggage & Bags", "Office Supplies", "Religious & Ceremonial", "Mature"];

        $option1 = "Color";
        $option1vals = ["Red", "Black", "White"];

        $option2 = "Size";
        $option2vals = ["Large", "Small", "Medium"];

        $option3 = "Material";
        $option3vals = ["Plastic", "Rubber", "Metal"];

        $variant_sku = $faker->bothify('?###??##');

        //adding the data from the array
        for ($i = 0; $i < $numberOfProduct; $i++) {

            $title = $faker->realText(50);
            $_handle = Str::slug($title);
            $desc = $faker->text(200);
            $vendor = $faker->word();
            $tags = implode(",", $faker->words(5));

            $type = $StandardizedProductType[$rand_keys = array_rand($StandardizedProductType, 1)];

            $published = true;
            $nOfImages = mt_rand(1, 3);
            $processedImage = 1;

            $nOfoption1 = mt_rand(1, 3);
            $nOfoption2 = mt_rand(1, $nOfoption1 >= 2 ? 2 : 3);
            $nOfoption3 = mt_rand(1, $nOfoption1 >= 2 ? 1 : 2);

            shuffle($option1vals);

            for ($j = 0; $j < $nOfoption1; $j++) {
                shuffle($option2vals);

                for ($k = 0; $k < $nOfoption2; $k++) {
                    shuffle($option3vals);

                    for ($m = 0; $m < $nOfoption3; $m++) {

                        $qty = $faker->numberBetween(10, 50);
                        $grams = $faker->numberBetween(100, 1000);
                        $fullfilment_service = 'manual';
                        $vprice = $faker->numberBetween($min = 100, $max = 600);
                        $src = "https://source.unsplash.com/user/c_v_r/600x600";

                        ($j == $k && $k == $m && $j == 0) ? $isOnce = 1 : $isOnce = 0;

                        fputcsv($handle, [
                            $_handle,
                            $isOnce ? $title : "",
                            $isOnce ? $desc : "",
                            $isOnce ? $vendor : "",
                            $isOnce ? $type : "",
                            $isOnce ? $tags : "",
                            $isOnce ? $published : "",

                            $isOnce ? $option1 : "",
                            $option1vals[$j],
                            $isOnce ? $option2 : "",
                            $option2vals[$k],
                            $isOnce ? $option3 : "",
                            $option3vals[$m],

                            $variant_sku . $j . $k . $m,
                            $grams,
                            "g",
                            $qty,
                            "deny",
                            $fullfilment_service,
                            $vprice,
                            $vprice + ($vprice * 20 / 100),
                            "true",
                            "true",
                            ($nOfImages >= $processedImage) ? $src : "",
                            ($nOfImages >= $processedImage) ? $processedImage  : "",
                            ($nOfImages >= $processedImage) ? "Product Image" : "",
                            $isOnce ? "active" : "",
                        ]);
                        $processedImage++;
                    }
                }
            }
        }
        fclose($handle);

        //download csv file
        return Response::download($filename, "download.csv", $headers);
    }
}