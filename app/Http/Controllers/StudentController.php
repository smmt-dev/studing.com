<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Student::get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate data
        $data = $request->only('name','course_id');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'course_id' => 'required|exists:App\Models\Course,id'
        ]);

        // die("here");
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new student
        $student = Student::create([
            'name' => $request->name,
            'course_id' => $request->course_id
        ]);

        //student created, return success response
        return response()->json([
            'success' => true,
            'message' => 'student created successfully',
            'data' => $student
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, student not found.'
            ], 400);
        }
    
        return $student;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //Validate data
        $data = $request->only('name','course_id');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'course_id' => 'required|exists:App\Models\Course,id'
        ]);

       //Send failed response if request is not valid
       if ($validator->fails()) {
           return response()->json(['error' => $validator->messages()], 200);
       }

       //Request is valid, update student
        $student = $student->update([
           'name' => $request->name,
           'course_id' => $request->course_id
       ]);

       //student updated, return success response
       return response()->json([
           'success' => true,
           'message' => 'student updated successfully',
           'data' => $student
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json([
            'success' => true,
            'message' => 'student deleted successfully'
        ], Response::HTTP_OK);
    }
}