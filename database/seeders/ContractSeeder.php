<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Contract::truncate();
        Schema::enableForeignKeyConstraints();
        
        Contract::factory()->count(10)->create();
    }
}
