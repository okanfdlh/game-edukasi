<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('questions')->insert([
            [
                'category' => 'kampus',
                'question_text' => 'Berapa hasil 5 + 3?',
                'option_a' => '6',
                'option_b' => '7',
                'option_c' => '8',
                'option_d' => '9',
                'answer' => 'c',
            ],
            [
                'category' => 'umum',
                'question_text' => 'Berapa hasil 5 + 3?',
                'option_a' => '6',
                'option_b' => '7',
                'option_c' => '8',
                'option_d' => '9',
                'answer' => 'c',
            ],[
                'category' => 'matematika',
                'question_text' => 'Berapa hasil 5 + 3?',
                'option_a' => '6',
                'option_b' => '7',
                'option_c' => '8',
                'option_d' => '9',
                'answer' => 'c',
            ],
            // Tambahkan soal lainnya
        ]);
    }

}
