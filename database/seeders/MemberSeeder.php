<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Church;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Member::factory()->count(20)->state(new Sequence(
            fn () => ['church_id' => Church::all()->random()]
        ))->create();
    }
}
