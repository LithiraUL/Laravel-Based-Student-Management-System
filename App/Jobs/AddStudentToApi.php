<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class AddStudentToApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $student;

    public function __construct($student)
    {
        $this->student = $student;
    }

    public function handle()
    {
        Http::withToken(session('api_token'))
            ->post('http://127.0.0.1:8000/api/students', $this->student);
    }
}
