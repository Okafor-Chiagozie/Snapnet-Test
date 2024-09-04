<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateReport implements ShouldQueue
{
   use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   protected $type;

   public function __construct($type)
   {
      $this->type = $type;
   }

   public function handle()
   {
      $data = [];

      if ($this->type === 'projects') {
         $data = Project::with('employees')->get();
      } elseif ($this->type === 'employees') {
         $data = Employee::with('project')->get();
      }

      $filename = $this->type . '_report_' . now()->format('Y_m_d_H_i_s') . '.json';
      Storage::disk('local')->put('reports/' . $filename, $data->toJson());

      // Further processing such as sending an email with the report can be added here
   }
}
