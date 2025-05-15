<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
  protected $model = Task::class;

  public function definition(): array
  {
    return [
      'name' => $this->faker->sentence(3),
      'description' => $this->faker->paragraph(3),
      'edit_token' => Str::random(32),
    ];
  }
}
