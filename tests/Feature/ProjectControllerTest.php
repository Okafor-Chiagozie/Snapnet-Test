<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
   use RefreshDatabase;

   public function test_can_create_project()
   {
      $response = $this->postJson('/api/projects', [
         'name' => 'Test Project',
         'description' => 'Test Description',
         'status' => 'pending',
         'start_date' => now()->toDateString(),
         'end_date' => now()->addWeek()->toDateString(),
      ]);

      $response->assertStatus(201);
      $this->assertDatabaseHas('projects', ['name' => 'Test Project']);
   }

   public function test_can_update_project()
   {
      $project = Project::factory()->create();

      $response = $this->putJson('/api/projects/' . $project->id, [
         'name' => 'Updated Project Name',
         'description' => $project->description,
         'status' => $project->status,
         'start_date' => $project->start_date,
         'end_date' => $project->end_date,
      ]);

      $response->assertStatus(200);
      $this->assertDatabaseHas('projects', ['name' => 'Updated Project Name']);
   }

   // Add more tests for index, show, delete, etc.
}
