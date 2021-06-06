<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product')->insert([
            'name' => 'rice',
            'price' => '25.00',
        ]);
        DB::table('product')->insert([
            'name' => 'milk',
            'price' => '4.00',
        ]);
    }
}
