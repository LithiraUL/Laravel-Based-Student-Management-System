<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class UpdateStudentToApi implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $id;
    protected $studentData;

    public function __construct($id, $studentData)
    {
        $this->id = $id;
        $this->studentData = $studentData;
    }

    public function handle()
    {
        try {
            Http::withToken(session('api_token'))
                ->put('http://127.0.0.1:8000/api/students/' . $this->id, $this->studentData);
        } catch (RequestException $e) {
            // Handle errors if the API request fails
            \Log::error("Failed to update student via API: " . $e->getMessage());
        }
    }
}
