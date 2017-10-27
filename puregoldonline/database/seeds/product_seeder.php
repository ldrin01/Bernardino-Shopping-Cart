<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class product_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $this->category();
        $this->products();
    }

    public function category(){
        echo "  CATEGORIES\n    |";

        $categories = array("Dairy","Drinks","Canned","Biscuits","Shampoo");

        $i=0;
        while ($i < 5) {
            DB::table('categories')->insert([
                'name' => $categories[$i],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $i++;
            echo $i." ";
        }
        echo "\n\n";
    }

    public function products(){
        echo "  PRODUCTS";

        $categories = array("Dairy","Drinks","Canned","Biscuits","Shampoo");
        $path = array("bearbrand.jpg","anchor.jpg","eden.jpg","dutchmill.jpg","redbull.jpg","kopiko78.jpg","ligo.jpg","sanmarino.jpg","saba.jpg","oreo.jpg","skyflakes.jpg","presto.jpg","sunsilk.jpg","creamsilk.jpg","dovemen.jpg");
        $product_name = array("Bear Brand","Anchor","Eden","Dutch Mill","Red Bull","Kopiko 78","Ligo","San Marino","Saba","Oreo","Sky Flakes","Presto","Sunsilk","Creamsilk","Dove");
        $product_description = array("Milk","Butter","Cheese","Yougurt","Energy Drink","Cold Coffee","Sardines","Corned Tuna","Squid","Chocoate Biscuits","Sky Flakes","Peanut Butter","Shampoo","Conditioner","Men");

        $i=0;
        $a=0;
        while ($i < 5) {
            echo "\n    |".$categories[$i];
            if ($categories[$i] == "Dairy") {
                while ($a < 3) {
                    DB::table('products')->insert([
                        'name' => $product_name[$a],
                        'path' => $path[$a],
                        'description' => $product_description[$a],
                        'category_id' => $i+1,
                        'price' => rand(58, 160),
                        'stock' => rand(rand(4, 11), rand(13, 19)),
                        'barcode' => rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    $temp = $a+1;
                    echo "\n      |".$temp." = OK";
                    $a++;
                }
            }else if ($categories[$i] == "Drinks") {
                while ($a < 6) {
                    DB::table('products')->insert([
                        'name' => $product_name[$a],
                        'path' => $path[$a],
                        'description' => $product_description[$a],
                        'category_id' => $i+1,
                        'price' => rand(58, 160),
                        'stock' => rand(rand(4, 11), rand(13, 19)),
                        'barcode' => rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    $temp = $a+1;
                    echo "\n      |".$temp." = OK";
                    $a++;
                }
            }else if ($categories[$i] == "Canned") {
                while ($a < 9) {
                    DB::table('products')->insert([
                        'name' => $product_name[$a],
                        'path' => $path[$a],
                        'description' => $product_description[$a],
                        'category_id' => $i+1,
                        'price' => rand(58, 160),
                        'stock' => rand(rand(4, 11), rand(13, 19)),
                        'barcode' => rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    $temp = $a+1;
                    echo "\n      |".$temp." = OK";
                    $a++;
                }
            }else if ($categories[$i] == "Biscuits") {
                while ($a < 12) {
                    DB::table('products')->insert([
                        'name' => $product_name[$a],
                        'path' => $path[$a],
                        'description' => $product_description[$a],
                        'category_id' => $i+1,
                        'price' => rand(58, 160),
                        'stock' => rand(rand(4, 11), rand(13, 19)),
                        'barcode' => rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    $temp = $a+1;
                    echo "\n      |".$temp." = OK";
                    $a++;
                }
            }else if ($categories[$i] == "Shampoo") {
                while ($a < 15) {
                    DB::table('products')->insert([
                        'name' => $product_name[$a],
                        'path' => $path[$a],
                        'description' => $product_description[$a],
                        'category_id' => $i+1,
                        'price' => rand(58, 160),
                        'stock' => rand(rand(4, 11), rand(13, 19)),
                        'barcode' => rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    $temp = $a+1;
                    echo "\n      |".$temp." = OK";
                    $a++;
                }
            }

            $i++;
        }
        echo "\n\n";
    }
}
