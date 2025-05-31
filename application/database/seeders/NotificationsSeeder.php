<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('notifications')->insert([
            ['user_id'=>1,'type'=>'system','title'=>'Welcome','message'=>'Welcome to Bunch of Clubs','is_read'=>0,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
