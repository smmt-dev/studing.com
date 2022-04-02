<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Course::get();
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
         $data = $request->only('name');
         $validator = Validator::make($data, [
             'name' => 'required|string'
         ]);
 
         //Send failed response if request is not valid
         if ($validator->fails()) {
             return response()->json(['error' => $validator->messages()], 200);
         }
 
         //Request is valid, create new course
         $course = Course::create([
             'name' => $request->name
         ]);
 
         //course created, return success response
         return response()->json([
             'success' => true,
             'message' => 'Course created successfully',
             'data' => $course
         ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, course not found.'
            ], 400);
        }
    
        return $course;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
       //Validate data
       $data = $request->only('name');
       $validator = Validator::make($data, [
           'name' => 'required|string'
       ]);

       //Send failed response if request is not valid
       if ($validator->fails()) {
           return response()->json(['error' => $validator->messages()], 200);
       }

       //Request is valid, update course
       $course = $course->update([
           'name' => $request->name
       ]);

       //course updated, return success response
       return response()->json([
           'success' => true,
           'message' => 'course updated successfully',
           'data' => $course
       ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json([
            'success' => true,
            'message' => 'course deleted successfully'
        ], Response::HTTP_OK);
    }
}