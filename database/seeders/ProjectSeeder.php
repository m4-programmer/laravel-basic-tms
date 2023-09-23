<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Request;
use function Webmozart\Assert\Tests\StaticAnalysis\ip;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['title'=>'School Project'],
            ['title'=>'House Project'],
            ['title'=>'Office Project'],
            ['title'=>'Miscellaneous Project'],
        ];
        foreach ($data as $i){
            Project::updateOrCreate(['title' => $i['title']], ['title' => $i['title']]);
        }
        $projects = Project::all();

        foreach ($projects as $project) {
            for ($i = 1; $i <= 2; $i++) {
                Task::updateorCreate(
                    ['name' => "{$project->title} Task {$i}"],
                    [
                    'name' => "{$project->title} Task {$i}",
                    'timestamp' => now(),
                    'ip'=>Request::ip(),
                    'priority' => fake()->randomElement(['High','Medium','Low']),
                    'project_id' => $project->id,
                ]);
            }
        }
    }
}
