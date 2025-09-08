<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $courses = [
            [
                'title' => 'Laravel 11 Dasar sampai Mahir',
                'slug' => Str::slug('Laravel 11 Dasar sampai Mahir'),
                'description' => 'Belajar Laravel 11 dari dasar hingga mahir, membangun aplikasi web modern dengan Breeze dan Spatie.',
                'category_course_id' => 1, // Programming
                'language_id' => 1, // Indonesia
                'publisher' => 'Build With Angga',
                'working_publisher' => 'Fullstack Developer',
                'level_id' => 2, // Intermediate
                'duration' => 120,
                'price' => 150000,
                'discount_price' => 100000,
                'path_thumbnail' => 'uploads/course_thumbnails/laravel.jpg',
                'is_publish' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Fundamental Web Development',
                'slug' => Str::slug('Fundamental Web Development'),
                'description' => 'Pelajari HTML, CSS, dan JavaScript untuk memulai karir sebagai Web Developer.',
                'category_course_id' => 2, // Web Development
                'language_id' => 1,
                'publisher' => 'Code Academy',
                'working_publisher' => 'Frontend Engineer',
                'level_id' => 1,
                'duration' => 90,
                'price' => 100000,
                'discount_price' => 75000,
                'path_thumbnail' => 'uploads/course_thumbnails/webdev.jpg',
                'is_publish' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'React Native Mobile Apps',
                'slug' => Str::slug('React Native Mobile Apps'),
                'description' => 'Membuat aplikasi mobile Android & iOS menggunakan React Native.',
                'category_course_id' => 3, // Mobile Development
                'language_id' => 1,
                'publisher' => 'Udemy Clone',
                'working_publisher' => 'Mobile Developer',
                'level_id' => 2,
                'duration' => 100,
                'price' => 200000,
                'discount_price' => 150000,
                'path_thumbnail' => 'uploads/course_thumbnails/reactnative.jpg',
                'is_publish' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Data Science dengan Python',
                'slug' => Str::slug('Data Science dengan Python'),
                'description' => 'Analisis data, machine learning, dan visualisasi menggunakan Python.',
                'category_course_id' => 4, // Data Science
                'language_id' => 1,
                'publisher' => 'Dicoding',
                'working_publisher' => 'Data Scientist',
                'level_id' => 3,
                'duration' => 180,
                'price' => 250000,
                'discount_price' => 200000,
                'path_thumbnail' => 'uploads/course_thumbnails/datascience.jpg',
                'is_publish' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Artificial Intelligence for Beginners',
                'slug' => Str::slug('Artificial Intelligence for Beginners'),
                'description' => 'Dasar-dasar AI dan implementasi sederhana menggunakan Python.',
                'category_course_id' => 5, // AI
                'language_id' => 2, // English
                'publisher' => 'AI Academy',
                'working_publisher' => 'Machine Learning Engineer',
                'level_id' => 1,
                'duration' => 110,
                'price' => 180000,
                'discount_price' => 120000,
                'path_thumbnail' => 'uploads/course_thumbnails/ai.jpg',
                'is_publish' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'UI/UX Design Principles',
                'slug' => Str::slug('UI/UX Design Principles'),
                'description' => 'Mendesain aplikasi dan website yang user-friendly dengan Figma.',
                'category_course_id' => 6, // Design
                'language_id' => 1,
                'publisher' => 'Design Academy',
                'working_publisher' => 'UI/UX Designer',
                'level_id' => 1,
                'duration' => 80,
                'price' => 120000,
                'discount_price' => 90000,
                'path_thumbnail' => 'uploads/course_thumbnails/uiux.jpg',
                'is_publish' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Digital Marketing Strategy',
                'slug' => Str::slug('Digital Marketing Strategy'),
                'description' => 'Strategi marketing digital dengan SEO, SEM, dan Social Media.',
                'category_course_id' => 7, // Digital Marketing
                'language_id' => 1,
                'publisher' => 'Marketing Expert',
                'working_publisher' => 'Digital Marketer',
                'level_id' => 2,
                'duration' => 70,
                'price' => 100000,
                'discount_price' => 80000,
                'path_thumbnail' => 'uploads/course_thumbnails/marketing.jpg',
                'is_publish' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Business Management Basics',
                'slug' => Str::slug('Business Management Basics'),
                'description' => 'Dasar-dasar manajemen bisnis untuk startup dan UMKM.',
                'category_course_id' => 8, // Business
                'language_id' => 1,
                'publisher' => 'Entrepreneur Hub',
                'working_publisher' => 'Business Coach',
                'level_id' => 1,
                'duration' => 95,
                'price' => 150000,
                'discount_price' => 100000,
                'path_thumbnail' => 'uploads/course_thumbnails/business.jpg',
                'is_publish' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Finance & Accounting 101',
                'slug' => Str::slug('Finance & Accounting 101'),
                'description' => 'Belajar keuangan dasar untuk pribadi dan bisnis.',
                'category_course_id' => 9, // Finance
                'language_id' => 1,
                'publisher' => 'Finance Academy',
                'working_publisher' => 'Financial Analyst',
                'level_id' => 1,
                'duration' => 85,
                'price' => 130000,
                'discount_price' => 95000,
                'path_thumbnail' => 'uploads/course_thumbnails/finance.jpg',
                'is_publish' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Personal Development Mastery',
                'slug' => Str::slug('Personal Development Mastery'),
                'description' => 'Mengembangkan soft skill, komunikasi, dan leadership.',
                'category_course_id' => 10, // Personal Development
                'language_id' => 1,
                'publisher' => 'Self Growth Academy',
                'working_publisher' => 'Motivator',
                'level_id' => 1,
                'duration' => 60,
                'price' => 100000,
                'discount_price' => 75000,
                'path_thumbnail' => 'uploads/course_thumbnails/selfgrowth.jpg',
                'is_publish' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('courses')->insert($courses);
    }
}
