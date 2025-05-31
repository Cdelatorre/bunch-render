<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sections')->insert([
            ['page_id'=>1,'name'=>'hero','content'=>json_encode(['headline'=>'Welcome to Bunch of Clubs','subtext'=>'Find the best gyms near you']), 'ordering'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['page_id'=>1,'name'=>'features','content'=>json_encode(['items'=>['Easy booking','Verified reviews']]), 'ordering'=>2,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
