<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Task;

class TaskRequest extends FormRequest
{

  public function rules(): array
  {
    return Task::rules();
  }
}
