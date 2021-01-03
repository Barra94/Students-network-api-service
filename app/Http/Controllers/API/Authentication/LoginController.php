<?php

namespace App\Http\Controllers\API\Authentication;

use App\Models\Student;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdatePasswordRequest;

class LoginController extends Controller
{
    /**
     * Student Login.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(LoginRequest $request)
    {
        //TODO Try to divide the code.
        $student = Student::where('email', $request->email)->first();

        if (! $student || ! Hash::check($request->password, $student->password)) {
                return response()->json([
                    'message' => 'The username or password was not correct.',
                ], 401);
        }

        $student->tokens()->delete();

        return response()->json([
            'token' => $student->createToken('web-application')->plainTextToken,
        ]);
    }

    /**
     * Student update password.
     *
     * @param UpdatePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePasswordRequest $request)
    {
        $validated = $request->validated();

        $student = $request->user();
        $student->password = Hash::make($validated['new_password']);
        $student->save();

        //TODO remove all the update return function. it returns 200 by default.
        return response()->json([
            "message" => "record updated successfully"
        ], 200);
    }
}