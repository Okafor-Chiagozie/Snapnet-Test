<?php

namespace App\Mail;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
   use Queueable, SerializesModels;

   public $employee;

   public function __construct(Employee $employee)
   {
      $this->employee = $employee;
   }

   public function build()
   {
      return $this->view('emails.welcome')->with(['employee' => $this->employee]);
   }
}
