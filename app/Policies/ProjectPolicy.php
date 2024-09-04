<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
   use HandlesAuthorization;

   public function update(Employee $employee, Project $project)
   {
      return $project->employees()->where('id', $employee->id)->exists();
   }

   public function delete(Employee $employee, Project $project)
   {
      return $project->employees()->where('id', $employee->id)->exists();
   }
}
