<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Request;
use App\Models\Spot;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Request::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'studentId' => Student::factory(),
            'projectId' => Project::factory(),
            'spotId' => Spot::factory(),
            'created_at' => $this->faker->dateTime,
            'updated_at' => now(),
        ];
    }
}
