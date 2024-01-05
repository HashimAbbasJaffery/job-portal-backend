<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\CreateAccountMail;


class CreateAccountMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $name;
    protected $code;
    protected $email;
    public function __construct($name, $code, $email)
    {
        $this->name = $name;
        $this->code = $code;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        $mailData = [
            "name" => $this->name,
            "uuid" => $this->code
        ];
    
        Mail::to($this->email)->send(new CreateAccountMail($mailData));
    }
}
