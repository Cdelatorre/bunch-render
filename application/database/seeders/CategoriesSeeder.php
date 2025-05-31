<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $categories = collect([
            'Yoga',
            'CrossFit',
            'Pilates',
            'Cycling',
            'Boxing',
        ])->map(fn ($name, $key) => [
            'id'         => $key + 1, // genera id del 1 al 5
            'name'       => $name,
            'slug'       => Str::slug($name),
            'parent_id'  => null,
            'created_at' => $now,
            'updated_at' => $now,
            'status'     => 1,
            'icon'       => '<i class="fab fa-accusoft"></i>',
        ])->all();

        DB::table('categories')->insert($categories);
    }
}
