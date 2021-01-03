<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Todo check if the user is logged in.

        $skills = Skill::all();
        return response($skills, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateSkillRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSkillRequest $request)
    {
        //Todo check if the logged in user is admin.

        $validated = $request->validated();

        try{
            $skill = new Skill(['title' => $validated['skill'], 'type' => $validated['type']]);
            $skill->save();

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
        //Todo check if the user is logged in.

        $skill = Skill::findOrFail($id);
        return response($skill, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSkillRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSkillRequest $request, $id)
    {
        //Todo check if the logged in user is admin.

        $validated = $request->validated();

        $skill = Skill::findOrFail($id);

        $skill->title = (isset($validated['skill'])) ? $validated['skill'] : $skill->title;
        $skill->type = (isset($validated['type'])) ? $validated['type'] : $skill->type;

        try{
            $skill->save();

            return response()->json([
                "message" => "record updated successfully"
            ], 200);
        }
        catch (\Exception $e){
            return response()->json(["message" => "skill is not updated successfully."], 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Todo check if the logged in user is admin.

        $skill = Skill::findOrFail($id);

        $skill->delete();

        return response()->json([
            "message" => "record deleted"
        ], 202);
    }
}
