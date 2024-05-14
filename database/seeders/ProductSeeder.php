<?php

namespace Database\Seeders;


use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i <= 20; $i++){
            Product::create([
                'id_kategori'=> rand(1,3),
                'id_subkategori'=> rand(1,4),
                'nama_barang'=> 'Loren Ipsum Dolor Sit amet',
                'harga'=> rand(1000,100000),
                'diskon'=> 0,
                'bahan'=> 'Loren Ipsum Dolor Sit amet',
                'tags'=> 'Loren, Ipsum, Dolor, Sit, amet',
                'sku'=> Str::random(0),
                'ukuran'=> 'S,M,L,XL',
                'warna'=> 'Hitam,Biru,Kuning,Putih,Hijau',
                'gambar' => 'shop_image_' . $i . '.jpg',
                'deskripsi' => 'Loren Ipsum Dolor Sit amet',
            ]);
        }
    }
}
