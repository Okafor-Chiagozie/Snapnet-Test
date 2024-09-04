<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
   use RefreshDatabase;

   public function test_project_has_employees()
   {
      $project = Project::factory()->create();
      $employee = Employee::factory()->create(['project_id' => $project->id]);

      $this->assertTrue($project->employees->contains($employee));
   }
}
