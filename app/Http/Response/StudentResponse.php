<?php

namespace App\Http\Response;

use App\Models\Spot;
use App\Models\Student;

class StudentResponse
{
    /**
     * Get the full student response.
     *
     * @param Student $student
     * @return array
     */
    public static function get(Student $student)
    {
        $student->load('requests.project');
        $student->load('spots.project');
        $student->load('projects');

        return [
            'id' => $student->id,
            'fontysId' => $student->fontysId,
            'givenName' => $student->givenName,
            'surName' => $student->surName,
            'initials' => $student->initials,
            'displayName' => $student->displayName,
            'email' => $student->email,
            'photo' => $student->photo,
            'department' => $student->department,
            'title' => $student->title,
            'personalTitle' => $student->personalTitle,
            'employeeId' => $student->employeeId,
            'description' => $student->description,
            'created_at' => $student->created_at,
            'updated_at' => $student->updated_at,
            'requestedToJoinProjects' => $student->requests->map(function ($requestToJoin) use ($student){
                return [
                    'requestId' => $requestToJoin->id,
                    'projectId' => $requestToJoin->projectId,
                    'spotId' => $requestToJoin->spotId,
                    'spotDescription' => Spot::find($requestToJoin->spotId)->description,
                    'project' => $requestToJoin->project,
                ];
            }),
            'ownedProjects' => $student->projects,
            'joinedProjects' => $student->spots->map(function ($spot) use ($student){
                return [

                    'description' => $spot->description,
                    'projectId' => $spot->projectId,
                    'spotId' => $spot->spotId,
                    'project' => $spot->project,
                ];
            }),
            'skills' => $student->skills->map(function ($skill) use ($student){
                return [
                    'id' => $skill->id,
                    'title' => $skill->title,
                    'type' => $skill->type,
                    'level' => $skill->pivot->level,
                    'endorsedBy' => $skill->endorsements->where('studentId', $student->id)->map(function ($endorsement) use ($student){
                        return Student::find($endorsement->endorserId);
                    }),
                ];
            }),
        ];
    }
}