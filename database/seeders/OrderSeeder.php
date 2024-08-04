<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'total' => '1000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Order::create([
            'total' => '2000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
