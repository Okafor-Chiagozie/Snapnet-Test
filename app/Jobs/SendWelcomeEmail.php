<?php

namespace App\Jobs;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue
{
   use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   protected $employee;

   public function __construct(Employee $employee)
   {
      $this->employee = $employee;
   }

   public function handle()
   {
      Mail::to($this->employee->email)->send(new \App\Mail\WelcomeMail($this->employee));
   }
}
