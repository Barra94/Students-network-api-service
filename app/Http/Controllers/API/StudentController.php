<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Controllers\Controller;
use App\Http\Response\StudentResponse;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        $students->load('skills');
        return response($students, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);

        $responseObject = StudentResponse::get($student);

        return response($responseObject, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStudentRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, $id)
    {
        //TODO do it using middleware.
        if($request->user()->id != $id) {
            return response()->json([
                "message" => "Unauthorized."
            ], 401);
        }

        $validated = $request->validated();

        $student = Student::findOrFail($id);

        $student->givenName = (isset($validated['givenName'])) ? $validated['givenName'] : $student->givenName;
        $student->surName =  (isset($validated['surName'])) ? $validated['surName'] : $student->surName;
        $student->initials =  (isset($validated['initials'])) ? $validated['initials'] : $student->initials;
        $student->displayName = (isset($validated['displayName'])) ? $validated['displayName'] : $student->displayName;
        $student->description = (isset($validated['description'])) ? $validated['description'] : $student->description;

        $student->save();

        return response()->json([
            "message" => "record updated successfully"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param Request $httpRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, Request $httpRequest)
    {
        //TODO do it using middleware.
        if($httpRequest->user()->id != $id) {
            return response()->json([
                "message" => "Unauthorized."
            ], 401);
        }

        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json([
            "message" => "records deleted"
        ], 202);
    }
}
