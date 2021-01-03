<?php

namespace App\Http\Controllers\API;

use App\Models\Student;
use App\Models\Endorsement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EndorsementsController extends Controller
{
    /**
     * Endorse a student' skill.
     *
     * @param Request $request
     * @param $student_id
     * @param $skill_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $student_id, $skill_id){
        $student = $request->user();
        $studentToEndorse = Student::findOrFail($student_id);

        try{
            $endorsement = new Endorsement(['studentId' => $studentToEndorse->id, 'skillId' => $skill_id, 'endorserId' => $student->id]);

            $endorsement->save();

            return response()->json(["message" => "skill is endorsed successfully."], 201);
        }catch (\Exception $e){

            return response()->json(["message" => "skill is not endorsed successfully."], 400);
        }
    }
}