<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;

class EndpointTest extends TestCase
{
    // use RefreshDatabase; Not working with Mongo
    public function test_can_list_tasks(): void
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200);
        $this->assertGreaterThanOrEqual(3, count($response->json('data')));
    }


    public function test_can_create_task(): void
    {
        $response = $this->postJson('/api/tasks', [
            'name' => 'Test Task',
            'description' => 'Test Description'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', [
            'name' => 'Test Task',
            'description' => 'Test Description'
        ]);
    }

    public function test_can_show_task(): void
    {
        $task = Task::factory()->create();
        $response = $this->getJson("/api/tasks/{$task->id}");
        //Use resourceClass for exact json match
        $expected = (new \App\Http\Resources\TaskResource($task))->response()->getData(true);
        $response->assertExactJson($expected);
        $response->assertStatus(200);
    }

    public function test_create_task_fails_with_invalid_data(): void
    {
        // Too short
        $response = $this->postJson('/api/tasks', [
            'name' => 'Te',
            'description' => 'Tes'
        ]);
        $response->assertStatus(422);
        $this->assertDatabaseMissing('tasks', [
            'name' => 'Te',
            'description' => 'Tes'
        ]);

        // Too long
        $longName = str_repeat('A', 101);
        $longDesc = str_repeat('B', 5001);
        $response = $this->postJson('/api/tasks', [
            'name' => $longName,
            'description' => $longDesc
        ]);
        $response->assertStatus(422);
        $this->assertDatabaseMissing('tasks', [
            'name' => $longName,
            'description' => $longDesc
        ]);
    }

    public function test_can_create_and_update_task(): void
    {
        $response = $this->postJson('/api/tasks', [
            'name' => 'Test Task',
            'description' => 'Test Description'
        ]);
        $taskData = $response->json('task');
        $editUrl = $response->json('edit_url');
        $taskId = $taskData['id'];

        $response = $this->putJson($editUrl, [
            'name' => 'Updated Task' . $taskId,
            'description' => 'Updated Description' . $taskId
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'id' => $taskId,
            'name' => 'Updated Task' . $taskId,
            'description' => 'Updated Description' . $taskId
        ]);
    }

    public function test_can_create_and_soft_delete_task(): void
    {
        $response = $this->postJson('/api/tasks', [
            'name' => 'Test delete Task',
            'description' => 'Test delete Description'
        ]);
        $taskData = $response->json('task');
        $deleteUrl = $response->json('delete_url');
        $taskId = $taskData['id'];

        $response = $this->deleteJson($deleteUrl);
        $response->assertStatus(204);
        $this->assertSoftDeleted('tasks', [
            'id' => $taskId,
            'name' => 'Test delete Task',
            'description' => 'Test delete Description'
        ]);
    }
}
