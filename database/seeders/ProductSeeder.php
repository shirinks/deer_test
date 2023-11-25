<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Pink Pleated Dress With Tie Up Belt',
            'description'=>'Tailored with short sleeves and a V-neck in a pleated design.',
            'price'=>500,
            'stock_quantity'=>10
        ]);

        Product::create([
            'name' => 'BASICS Green Jazz Maxi Dress',
            'description'=>'Beat the blues wearing this supremely cool green jersey maxi dress featuring a side slit and a body hugging fit. Dress it up for the evening or keep it casual for the day; this baby will keep you in focus.',
            'price'=>715,
            'stock_quantity'=>57
        ]);

        Product::create([
            'name' => 'Mustard Peek A Boo Skater Dress',
            'description'=>'You can be sure to catch unlimited eyeballs with this fun and daring cut out mustard skater dress. It features cut out detail on the one side of the neckline.',
            'price'=>618,
            'stock_quantity'=>30
        ]);
        Product::create([
            'name' => 'Wine Pearl Embellished Bell Sleeve Dress',
            'description'=>'Chic and trendy, this wine dress is a summer must-have for all the divas. Features three quarter bell sleeves.',
            'price'=>1056,
            'stock_quantity'=>50
        ]);
        Product::create([
            'name' => 'Choker Skater Dress - Aqua Floral',
            'description'=>'Add oomph to your wardrobe with this gorgeous aqua floral skater dress featuring choker neck detail with V-neckline, side concealed zip and button closure at the nape.',
            'price'=>665,
            'stock_quantity'=>4
        ]);
        Product::create([
            'name' => 'Yellow Floral Dotted High Low Dress',
            'description'=>'Get the perfect summer look in this yellow midi dress that is equal parts chic and comfortable. Features floral print all over and a self-fabric tie-up.',
            'price'=>956,
            'stock_quantity'=>6
        ]);
    }
}
