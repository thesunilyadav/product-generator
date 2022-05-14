<?php

namespace Sunilyadav\Generator\Platforms;

use Faker\Factory;
use Response;
use File;
use Illuminate\Support\Str;

class BigcommerceGenerator
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
            'Item Type',
            'Product Name',
            'Product Type',
            'Product Code/SKU',
            'Brand Name',
            'Option Set Align',
            'Product Description',
            'Price',
            'Free Shipping',
            'Product Weight',
            'Allow Purchases?',
            'Product Visible?',
            'Track Inventory',
            'Current Stock Level',
            'Category',
            'Product Image File - 1',
            'Product Image Is Thumbnail - 1',
            'Product Image Sort - 1',
            'Search Keywords',
            'Page Title',
            'Product Condition',
            'Show Product Condition?',
            'Sort Order',
            'Product Tax Class',
            'Stop Processing Rules',
            'Product URL'
        ]);

        $CategoryType = ["Arts & Entertainment", "Baby & Toddler", "Cameras & Optics", "Apparel & Accessories", "Electronics", "Luggage & Bags", "Office Supplies", "Religious & Ceremonial", "Shop All", "Garden", "Bath", "Kitchen", "Publications", "Utility", "Mature"];

        $option1 = "Color";
        $option1vals = ["Red", "Black", "White"];

        $option2 = "Size";
        $option2vals = ["Large", "Small", "Medium"];

        $option3 = "Material";
        $option3vals = ["Plastic", "Rubber", "Metal"];


        //adding the data from the array
        for ($i = 0; $i < $numberOfProduct; $i++) {

            $variant_sku = $faker->bothify('?###??##');
            $keywords = implode(",", $faker->words(3));
            $title = $faker->realText(50);
            $_handle = Str::slug($title);
            $desc = $faker->text(200);
            $vendor = $faker->word();

            $type = $CategoryType[$rand_keys = array_rand($CategoryType, 1)];

            $nOfoption1 = mt_rand(1, 3);
            $nOfoption2 = mt_rand(1, $nOfoption1 >= 2 ? 2 : 3);
            $nOfoption3 = mt_rand(1, $nOfoption1 >= 2 ? 1 : 2);

            $vprice = $faker->numberBetween($min = 100, $max = 600);
            $qty = $faker->numberBetween(10, 50);
            $kg = $faker->numberBetween(1, 5);

            shuffle($option1vals);
            shuffle($option2vals);
            shuffle($option3vals);

            $src = "https://source.unsplash.com/user/c_v_r/600x600";

            fputcsv($handle, [
                "Product",
                $title,
                "P",
                $variant_sku,
                $vendor,
                "Right",
                $desc,
                $vprice,
                "N",
                $kg,
                "Y",
                "Y",
                "by product",
                $qty,
                $type,

                $src,
                "Y",
                0,

                $keywords,
                $title,
                "New",
                "N",
                0,
                "Default Tax Class",
                "N",
                "/" . $_handle . "/"
            ]);

            for ($j = 0; $j < $nOfoption1; $j++) {
                for ($k = 0; $k < $nOfoption2; $k++) {
                    for ($m = 0; $m < $nOfoption3; $m++) {
                        $src = "https://source.unsplash.com/user/c_v_r/600x6";

                        ($j == $k && $k == $m && $j == 0) ? $isOnce = 1 : $isOnce = 0;

                        fputcsv($handle, [
                            "SKU",
                            "[RT]" . $option1 . "=" . $option1vals[$j] . ",[S]" . $option2 . "=" . $option2vals[$k] . ",[RB]" . $option3 . "=" . $option3vals[$m],
                            "",
                            $variant_sku . $j . $k . $m,
                            "",
                            "",
                            "",
                            "",
                            "N",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            ""
                        ]);

                        fputcsv($handle, [
                            "Rule",
                            "",
                            "",
                            $variant_sku . $j . $k . $m,
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "Y",
                            "Y",
                            "",
                            "",
                            "",
                            $src . $k . $m,
                            "",
                            "N",

                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "N",
                            ""
                        ]);
                    }
                }
            }
        }
        fclose($handle);
        
        //download csv file
        return Response::download($filename, "download.csv", $headers);
    }
}
