<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Currency::factory()->count(3)->create();

         // Seed fake data
         $currencies = [
            ['title' => 'US Dollar', 'code' => '$', 'status'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['title' => 'Euro', 'code' => '€', 'status'=>false,'created_at'=>now(),'updated_at'=>now()],
            ['title' => 'British Pound', 'code' => '£', 'status'=>false,'created_at'=>now(),'updated_at'=>now()],
            ['title' => 'Kenyan Shilling', 'code' => 'Ksh', 'status'=>false,'created_at'=>now(),'updated_at'=>now()],
           
        ];
        foreach ($currencies as $currency) {
            DB::table('currency')->insert([
                'title' => $currency['title'],
                'code' => $currency['code'],
                'status'=>$currency['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
       
    }
}
