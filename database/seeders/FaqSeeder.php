<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faq')->insert([
            [
                'pertanyaan'=>'Question 1',
                'jawaban'=>"Again, this depends on the plan and provider you choose. Many pet insurance providers won't accept new policies for pets over a certain age. For some providers, the maximum age is as young as 6 years for dogs, but it averages out at 10 years for dogs and 15 years for cats. Fortunately, most providers won't end coverage after your pet turns a certain age. These restrictions usually apply to new policies, not existing ones. But the sooner you apply for coverage, the more you and your pet will benefit."
            ],
            [
                'pertanyaan'=>'Question 2',
                'jawaban'=>"Again, this depends on the plan and provider you choose. Many pet insurance providers won't accept new policies for pets over a certain age. For some providers, the maximum age is as young as 6 years for dogs, but it averages out at 10 years for dogs and 15 years for cats. Fortunately, most providers won't end coverage after your pet turns a certain age. These restrictions usually apply to new policies, not existing ones. But the sooner you apply for coverage, the more you and your pet will benefit."
            ],
            [
                'pertanyaan'=>'Question 3',
                'jawaban'=>"Again, this depends on the plan and provider you choose. Many pet insurance providers won't accept new policies for pets over a certain age. For some providers, the maximum age is as young as 6 years for dogs, but it averages out at 10 years for dogs and 15 years for cats. Fortunately, most providers won't end coverage after your pet turns a certain age. These restrictions usually apply to new policies, not existing ones. But the sooner you apply for coverage, the more you and your pet will benefit."
            ],
            [
                'pertanyaan'=>'Question 4',
                'jawaban'=>"Again, this depends on the plan and provider you choose. Many pet insurance providers won't accept new policies for pets over a certain age. For some providers, the maximum age is as young as 6 years for dogs, but it averages out at 10 years for dogs and 15 years for cats. Fortunately, most providers won't end coverage after your pet turns a certain age. These restrictions usually apply to new policies, not existing ones. But the sooner you apply for coverage, the more you and your pet will benefit."
            ],
            [
                'pertanyaan'=>'Question 5',
                'jawaban'=>"Again, this depends on the plan and provider you choose. Many pet insurance providers won't accept new policies for pets over a certain age. For some providers, the maximum age is as young as 6 years for dogs, but it averages out at 10 years for dogs and 15 years for cats. Fortunately, most providers won't end coverage after your pet turns a certain age. These restrictions usually apply to new policies, not existing ones. But the sooner you apply for coverage, the more you and your pet will benefit."
            ]
        ]);
    }
}
