<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Role;
use App\Models\Spot;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Spot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->word,
            'projectId' => Project::factory(),
            'roleId' => Role::factory(),
            'studentId' => Student::factory(),
            'created_at' => $this->faker->dateTime,
            'updated_at' => now(),
        ];
    }
}
