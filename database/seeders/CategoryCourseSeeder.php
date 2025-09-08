<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CategoryCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            ['name' => 'Programming', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Web Development', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mobile Development', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Data Science', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Artificial Intelligence', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Design', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Digital Marketing', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Business & Management', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finance & Accounting', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Personal Development', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('category_courses')->insert($categories);
    }
}
