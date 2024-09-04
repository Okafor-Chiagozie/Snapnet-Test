<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{

   use AuthorizesRequests;

   /**
    * Display a listing of the resource.
    */
   public function index()
   {
      return Project::with('employees')->get();
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'name' => 'required|unique:projects,name',
         'description' => 'nullable|string',
         'status' => 'required|string',
         'start_date' => 'required|date',
         'end_date' => 'nullable|date',
      ]);

      if ($validator->fails()) {
         return response()->json($validator->errors(), 422);
      }

      $project = Project::create($request->all());

      return response()->json($project, 201);
   }

   /**
    * Display the specified resource.
    */
   public function show($id)
   {
      $project = Project::with('employees')->findOrFail($id);

      return response()->json($project);
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, $id)
   {
      $project = Project::findOrFail($id);
      $this->authorize('update', $project);

      $validator = Validator::make($request->all(), [
         'name' => 'required|unique:projects,name,' . $project->id,
         'description' => 'nullable|string',
         'status' => 'required|string',
         'start_date' => 'required|date',
         'end_date' => 'nullable|date',
      ]);

      if ($validator->fails()) {
         return response()->json($validator->errors(), 422);
      }

      $project->update($request->all());

      return response()->json($project);
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy($id)
   {
      $project = Project::findOrFail($id);
      $this->authorize('delete', $project);
      
      $project->delete();

      return response()->json(null, 204);
   }
}
