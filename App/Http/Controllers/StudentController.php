<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Jobs\UpdateStudentToApi;

class StudentController extends Controller
{
    // Show the form for creating a new student
    public function create()
    {
        return view('students.create'); // Render the form view
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'age' => 'required|integer|min:1',
        ]);

        // Save to the local database
        Student::create($validated);

        try {
            // Send data to the API
            $response = Http::withToken(session('api_token'))
                ->timeout(10)
                ->post('http://127.0.0.1:8000/api/students', $validated);

            if (!$response->successful()) {
                \Log::error('API Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            \Log::error('API Connection Error: ' . $e->getMessage());
        }

        // Redirect to the student list page with a success message
        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    // Display a list of all students
    public function index()
    {
        try {
            $students = Student::all(); // Fetch all students from the database
            return view('students.index', compact('students')); // Pass students to the view
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error in StudentController@index: ' . $e->getMessage());
            return response()->view('errors.500', [], 500); // Return a 500 error view
        }
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'age' => 'required|integer|min:1',
        ]);

        // Update the local database
        $student = Student::findOrFail($id);
        $student->update($validated);

        // Dispatch the API update job
        UpdateStudentToApi::dispatch($id, $validated);

        // Redirect immediately to the student list page
        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        try {
            $student->delete();

            // Redirect back with success message
            return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
        } catch (\Exception $e) {
            // Redirect back with error message
            return redirect()->route('students.index')->with('error', 'Failed to delete the student.');
        }
    }



    // Unified method for searching and showing a student
    public function searchById(Request $request)
    {
        // Validate the input
        $request->validate([
            'student_id' => 'required|integer',
        ]);

        // Find the student by ID
        $student = Student::find($request->student_id);

        // Return the Students List page with search results
        return view('students.index', [
            'students' => Student::all(), // Existing list of students
            'searchResult' => $student,  // Pass the search result
        ]);
    }
}

