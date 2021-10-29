<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $time = Carbon::now()->subDays( random_int(1,100) ) ;
        return [
            'name'=>$this->faker->realText( random_int(10,15),1),
            'completed'=>$this->faker->boolean(),
            'completed_at'=> $time,
            'user_id'=>fn()=>User::all()->random(),
            'created_at' =>$time
        ];
    }
}
