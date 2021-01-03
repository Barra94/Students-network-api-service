<?php

namespace App\Http\Controllers\API\Profile;

use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileSkillController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param int $skill_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $skill_id)
    {
        $student = $request->user();
        $skill = Skill::findOrFail($skill_id);

        try{
            if(!is_null($skill)){
                $student->skills()->attach($skill, ['level' => null]);
                return response()->json(["message" => "skill added successfully."], 201);
            }
            else{
                return response()->json(["message" => "skill not added successfully."], 400);
            }
        }catch (\Exception $e){
            return response()->json(["message" => "skill not added successfully."], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $student = $request->user();

        return response($student->skills, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $skill_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $skill_id)
    {
        $skill = $request->user()->skills()->where('id', $skill_id)->first();
        if(is_null($skill)){
            return response()->json(["message" => "skill not found."], 400);
        }

        $student = $request->user();
        $student->skills()->detach($skill_id);

        return response()->json([
            "message" => "records deleted"
        ], 202);
    }
}