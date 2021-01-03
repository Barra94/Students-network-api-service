<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddSkillToStudentRequest;
use App\Models\Skill;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentSkillController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  AddSkillToStudentRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(AddSkillToStudentRequest $request, $id) //TODO don't allow adding a skill without a real skill in the database
    {
        $validated = $request->validated();
        $student = Student::findOrFail($id);
        $skill = Skill::all()->where('title' , '=', $validated['skill'])->first();

        try{
            if(!is_null($skill)){
                $student->skills()->attach($skill, ['level' => $validated['level']]);
            } else{
                $skill = new Skill(['title' => $validated['skill'], 'type' => $validated['type']]);
                $student->skills()->save($skill, ['level' => $validated['level']]);
            }

            return response()->json(["message" => "skill added successfully."], 201);
        }catch (\Exception $e){

            return response()->json(["message" => "skill not added successfully."], 400);
        }
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

        return response($student->skills, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $student_id
     * @param  int  $skill_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($student_id, $skill_id)
    {
        $student = Student::findOrFail($student_id);
        $student->skills()->detach($skill_id);

        return response()->json([
            "message" => "records deleted"
        ], 202);
    }
}
