<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SmsTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sms_templates')->insert([
            ['slug'=>'OTP','body'=>'Your OTP is {{code}}','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
