<?php

namespace Database\Seeders;

use App\Models\Todolist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class todolistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Todolist::create([
            'id'=>201,
            'activity'=>'tugas',
            'description'=>'mtk',
            'deadline'=>'20-12-10',
            'taskStatus'=>'onGoing',
        ]);
    }
}
