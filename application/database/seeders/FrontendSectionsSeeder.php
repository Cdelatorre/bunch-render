<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FrontendSectionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('frontend_sections')->insert([
            ['key'=>'header','content'=>json_encode(['logo'=>'logo.png','menu'=>[]]),'status'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['key'=>'footer','content'=>json_encode(['copyright'=>'© 2025 Bunch of Clubs']),'status'=>1,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
