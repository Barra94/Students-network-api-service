<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'ownerId' => Student::factory(),
            'startDate' => $this->faker->dateTime,
            'endDate' => $this->faker->dateTime,
            'created_at' => $this->faker->dateTime,
            'updated_at' => now(),
        ];
    }
}
