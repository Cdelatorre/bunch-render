<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FormsSeeder extends Seeder
{
    public function run(): void
    {
            DB::table('forms')->insert([
                ['id'=>1,'act'=>'kyc','form_data'=>json_encode([]),'created_at'=>now(),'updated_at'=>now()],
            ]);
    }
}
