<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
   /**
    * Display a listing of the resource.
    */
   public function index($projectId)
   {
      return Employee::where('project_id', $projectId)->get();
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request, $projectId)
   {
      $validator = Validator::make($request->all(), [
         'name' => 'required|string',
         'email' => 'required|email|unique:employees,email',
         'position' => 'required|string',
      ]);

      if ($validator->fails()) {
         return response()->json($validator->errors(), 422);
      }

      $employee = new Employee($request->all());
      $employee->project_id = $projectId;
      $employee->save();

      return response()->json($employee, 201);
   }

   /**
    * Display the specified resource.
    */
   public function show($projectId, $id)
   {
      $employee = Employee::where('project_id', $projectId)->findOrFail($id);

      return response()->json($employee);
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, $projectId, $id)
   {
      $employee = Employee::where('project_id', $projectId)->findOrFail($id);

      $validator = Validator::make($request->all(), [
         'name' => 'required|string',
         'email' => 'required|email|unique:employees,email,' . $employee->id,
         'position' => 'required|string',
      ]);

      if ($validator->fails()) {
         return response()->json($validator->errors(), 422);
      }

      $employee->update($request->all());

      return response()->json($employee);
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy($projectId, $id)
   {
      $employee = Employee::where('project_id', $projectId)->findOrFail($id);
      $employee->delete();

      return response()->json(null, 204);
   }

   /**
    * Restores the specified resource from storage.
    */
   public function restore($projectId, $id)
   {
      $employee = Employee::withTrashed()->where('project_id', $projectId)->findOrFail($id);
      $employee->restore();

      return response()->json($employee);
   }
}
