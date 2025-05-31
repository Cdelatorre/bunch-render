<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('languages')->insert([
            ['name'=>'English','code'=>'en','direction'=>'ltr','is_default'=>1,'is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Español','code'=>'es','direction'=>'ltr','is_default'=>0,'is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
