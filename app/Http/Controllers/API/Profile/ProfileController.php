<?php

namespace App\Http\Controllers\API\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Response\StudentResponse;
use App\Http\Requests\UpdateStudentRequest;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $student = $request->user();
        $responseObject = StudentResponse::get($student);

        return response($responseObject, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStudentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request)
    {
        $validated = $request->validated();

        $student = $request->user();

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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $student = $request->user();
        $student->delete();

        return response()->json([
            "message" => "records deleted"
        ], 202);
    }
}