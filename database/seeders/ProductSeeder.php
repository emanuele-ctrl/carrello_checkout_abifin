<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Zaino da trekking 30L', 'description' => 'Zaino resistente e impermeabile per escursioni di media durata.', 'price_cents' => 4990, 'stock' => 15],
            ['name' => 'Bottiglia termica 500ml', 'description' => 'Mantiene la temperatura fino a 12 ore, in acciaio inox.', 'price_cents' => 1290, 'stock' => 30],
            ['name' => 'Cuffie bluetooth wireless', 'description' => 'Audio ad alta fedeltà con cancellazione attiva del rumore.', 'price_cents' => 5990, 'stock' => 0],
            ['name' => 'Power bank 20000mAh', 'description' => 'Ricarica rapida per smartphone e tablet, doppia uscita USB.', 'price_cents' => 3490, 'stock' => 22],
            ['name' => 'Tappetino yoga antiscivolo', 'description' => 'Spessore 6mm, materiale ecologico, ideale per allenamento a casa.', 'price_cents' => 1990, 'stock' => 18],
            ['name' => 'Lampada da scrivania LED', 'description' => 'Luce regolabile su 5 livelli di intensità, ricarica USB-C.', 'price_cents' => 2490, 'stock' => 12],
            ['name' => 'Borraccia sportiva 1L', 'description' => 'Con misurini graduati e beccuccio antigoccia.', 'price_cents' => 990, 'stock' => 0],
            ['name' => 'Set coltelli da cucina', 'description' => 'Set di 5 coltelli in acciaio inossidabile con blocco porta coltelli.', 'price_cents' => 6990, 'stock' => 8],
            ['name' => 'Cuscino cervicale memory foam', 'description' => 'Supporto ergonomico per un sonno più confortevole.', 'price_cents' => 2290, 'stock' => 25],
            ['name' => 'Mouse wireless ergonomico', 'description' => 'Sensore ottico preciso, batteria fino a 6 mesi.', 'price_cents' => 1790, 'stock' => 40],
            ['name' => 'Tastiera meccanica compatta', 'description' => 'Switch blu, retroilluminazione RGB, layout italiano.', 'price_cents' => 5490, 'stock' => 14],
            ['name' => 'Organizer da scrivania in bambù', 'description' => 'Scomparti multipli per penne, cavi e accessori.', 'price_cents' => 1590, 'stock' => 20],
            ['name' => 'Termometro digitale da cucina', 'description' => 'Lettura istantanea, ideale per carne e liquidi.', 'price_cents' => 890, 'stock' => 33],
            ['name' => 'Cover protettiva smartphone', 'description' => 'Resistente agli urti, disponibile per i modelli più diffusi.', 'price_cents' => 1290, 'stock' => 50],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}