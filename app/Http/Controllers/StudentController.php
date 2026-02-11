<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json([
            'success' => true,
            'message' => 'Students retrieved successfully',
            'data' => $students
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'course' => 'required|string|max:255'
        ]);

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'course' => $request->course
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'data' => $student
        ], 201);
    }

    public function show(string $id)
    {
        $student = Student::find($id);
        
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Student retrieved successfully',
            'data' => $student
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $student = Student::find($id);
        
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:students,email,' . $id,
            'course' => 'sometimes|string|max:255'
        ]);

        $student->update($request->only(['name', 'email', 'course']));

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully',
            'data' => $student
        ], 200);
    }

    public function destroy(string $id)
    {
        $student = Student::find($id);
        
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully'
        ], 200);
    }
}