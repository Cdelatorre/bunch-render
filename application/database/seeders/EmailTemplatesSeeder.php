<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('email_templates')->insert([
            ['slug'=>'BOOKING_CONFIRM','subject'=>'Your booking is confirmed','body'=>'<p>Your booking has been confirmed.</p>','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
