<?php

namespace App\Http\Controllers\API\Authentication;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{

    /**
     * Request reset password code.
     *
     * @param string $email
     * @return \Illuminate\Http\JsonResponse
     */
    public function requestResetPasswordCode($email)
    {
        $student = Student::where('email', $email)->first();

        if(!is_null($student)){
            $student->requestResetPasswordCode();
        }
        else{
            return response()->json(['message' => 'Student with email: ' . $email . ' does not exists'], 404);
        }
    }

    /**
     * Reset the password.
     *
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $validated = $request->validated();

        $student = Student::where('email', $validated['email'])->first();

        if(is_null($student)){
            return response()->json(['message' => 'Student with email: ' . $validated['email'] . ' does not exists'], 404);
        }

        if($student->resetPasswordCode != $validated['code']){
            return response()->json(["message" => "The code is not correct."], 400);
        }

        $student->password = Hash::make($validated['new_password']);
        $student->resetPasswordCode = null;
        $student->resetPasswordCodeValidUntil = null;

        $student->save();

        return response()->json([
            "message" => "record updated successfully"
        ], 200);
    }
}