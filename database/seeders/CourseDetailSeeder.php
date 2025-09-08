<?php

namespace Database\Seeders;

use App\Models\CourseDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $url = 'https://youtu.be/Q7HR_TBO_Bk?si=3sioWhOVoWW-2rtB';

        $details = [
            // Course 1
            [
                'course_id' => 1,
                'sub_title' => 'Pengenalan Laravel 11',
                'description' => 'Dasar-dasar framework Laravel 11 dan setup awal.',
                'url' => $url,
            ],
            [
                'course_id' => 1,
                'sub_title' => 'Install Breeze & Spatie',
                'description' => 'Integrasi Breeze untuk auth dan Spatie untuk role management.',
                'url' => $url,
            ],

            // Course 2
            [
                'course_id' => 2,
                'sub_title' => 'Dasar Laravel Breeze',
                'description' => 'Setup Laravel Breeze untuk login dan register.',
                'url' => $url,
            ],
            [
                'course_id' => 2,
                'sub_title' => 'Middleware & Routing',
                'description' => 'Mengatur akses halaman menggunakan middleware.',
                'url' => $url,
            ],

            // Course 3
            [
                'course_id' => 3,
                'sub_title' => 'Pengenalan HTML & CSS',
                'description' => 'Dasar-dasar HTML dan styling dengan CSS.',
                'url' => $url,
            ],
            [
                'course_id' => 3,
                'sub_title' => 'Dasar JavaScript',
                'description' => 'Belajar variabel, fungsi, dan DOM.',
                'url' => $url,
            ],

            // Course 4
            [
                'course_id' => 4,
                'sub_title' => 'Mengenal Python',
                'description' => 'Dasar-dasar Python untuk data science.',
                'url' => $url,
            ],
            [
                'course_id' => 4,
                'sub_title' => 'Analisis Data dengan Pandas',
                'description' => 'Menggunakan Pandas untuk olah data.',
                'url' => $url,
            ],

            // Course 5
            [
                'course_id' => 5,
                'sub_title' => 'Dasar Digital Marketing',
                'description' => 'Belajar strategi marketing online.',
                'url' => $url,
            ],
            [
                'course_id' => 5,
                'sub_title' => 'SEO & SEM',
                'description' => 'Optimasi website untuk search engine.',
                'url' => $url,
            ],

            // Course 6
            [
                'course_id' => 6,
                'sub_title' => 'Mengenal UI/UX',
                'description' => 'Dasar desain pengalaman pengguna.',
                'url' => $url,
            ],
            [
                'course_id' => 6,
                'sub_title' => 'Figma for Beginner',
                'description' => 'Membuat desain aplikasi dengan Figma.',
                'url' => $url,
            ],

            // Course 7
            [
                'course_id' => 7,
                'sub_title' => 'Dasar React JS',
                'description' => 'Belajar konsep React & komponen.',
                'url' => $url,
            ],
            [
                'course_id' => 7,
                'sub_title' => 'State Management',
                'description' => 'Menggunakan state & props di React.',
                'url' => $url,
            ],

            // Course 8
            [
                'course_id' => 8,
                'sub_title' => 'Dasar Vue JS',
                'description' => 'Belajar reaktifitas di Vue JS.',
                'url' => $url,
            ],
            [
                'course_id' => 8,
                'sub_title' => 'Vue Router & Vuex',
                'description' => 'Routing dan state management di Vue.',
                'url' => $url,
            ],

            // Course 9
            [
                'course_id' => 9,
                'sub_title' => 'Mengenal Node JS',
                'description' => 'Dasar server-side dengan Node JS.',
                'url' => $url,
            ],
            [
                'course_id' => 9,
                'sub_title' => 'Express Framework',
                'description' => 'Belajar routing dengan Express JS.',
                'url' => $url,
            ],

            // Course 10
            [
                'course_id' => 10,
                'sub_title' => 'Pengenalan Database',
                'description' => 'Dasar-dasar SQL & database relasional.',
                'url' => $url,
            ],
            [
                'course_id' => 10,
                'sub_title' => 'Laravel & MySQL',
                'description' => 'Integrasi Laravel dengan database MySQL.',
                'url' => $url,
            ],
        ];

        foreach ($details as $detail) {
            CourseDetail::create($detail);
        }
    }
}
