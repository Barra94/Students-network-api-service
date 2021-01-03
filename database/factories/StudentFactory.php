<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fontysId' => $this->faker->name,
            'givenName' => $this->faker->firstName,
            'surName' => $this->faker->lastName,
            'initials' => $this->faker->randomLetter,
            'displayName' => $this->faker->name,
            'email' => $this->faker->unique()->email,
            'photo' => $this->faker->url,
            'department' => $this->faker->word,
            'title' => $this->faker->word,
            'personalTitle' => $this->faker->jobTitle,
            'employeeId' => $this->faker->unique()->numberBetween(),
            'password' => Hash::make('123456'),
            'description' => $this->faker->sentence(),
            'token' => Str::random(10),
            'tokenValidUntil' => $this->faker->dateTime,
            'fontysToken' => Str::random(10),
            'fontysTokenValidUntil' => $this->faker->dateTime,
            'created_at' => $this->faker->dateTime,
            'updated_at' => now(),
        ];
    }
}
