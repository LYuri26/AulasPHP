<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    public function run()
    {
        Task::create([
            'title' => 'Tarefa 1',
            'description' => 'Descrição da Tarefa 1',
        ]);

        Task::create([
            'title' => 'Tarefa 2',
            'description' => 'Descrição da Tarefa 2',
        ]);
    }
}
