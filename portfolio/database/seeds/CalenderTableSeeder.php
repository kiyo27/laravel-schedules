<?php

use App\Schedule;
use Illuminate\Database\Seeder;

class ScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'owner' => 1,
            'due_date' => '2020-11-01',
            'title' => 'My first schedule',
            'description' => 'My first task',
        ];
        $task = new Schedule();
        $task->fill($param)->save();

        $param = [
            'owner' => 1,
            'due_date' => '2020-11-10',
            'title' => 'Do something',
            'description' => '- something to progress',
        ];
        $task = new Schedule();
        $task->fill($param)->save();

        $param = [
            'owner' => 2,
            'due_date' => '2020-11-10',
            'title' => 'Anoter user tasks',
            'description' => 'This is anoter tasks',
        ];
        $task = new Schedule();
        $task->fill($param)->save();
    }
}
