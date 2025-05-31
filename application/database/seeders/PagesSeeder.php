<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pages')->insert([
            ['id'=>1,'name'=>'Home','slug'=>'/','tempname'=>'presets.default','secs'=>json_encode(['hero','features']),'is_default'=>1,'status'=>1,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
