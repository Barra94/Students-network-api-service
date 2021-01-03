<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Email\EmailSender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'token', 'tokenValidUntil', 'fontysToken', 'fontysTokenValidUntil'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'student';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = ['title'];

    /**
     * The skills of s student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill', 'student_skill', 'studentId', 'skillId')->withPivot('level');
    }

    /**
     * Get the requests for the students.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests()
    {
        return $this->hasMany(Request::class, 'studentId', 'id');
    }

    /**
     * Get the spots for the students.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spots()
    {
        return $this->hasMany(Spot::class, 'studentId', 'id');
    }

    /**
     * Get projects owned by the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'ownerId', 'id');
    }

    /**
     * The endorsements that the student did.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function endorsements()
    {
        return $this->hasMany(Endorsement::class, 'endorserId', 'id');
    }

    public static function boot()
    {
        //TODO refactor it using the event deleting
        parent::boot();

        Self::deleting(function ($student){

            //Delete the endorsements.
            Endorsement::where('studentId' , $student->id)->orWhere('endorserId', $student->id)->delete();

            //Delete every project owned by the student as well as its spots and the skills of every spot.
            Project::where('ownerId' , $student->id)->each(function ($project) {
                //Delete every spot-skill record.
                $project->spots()->each(function ($spot) {
                    $spot->skills()->detach();
                });

                //Delete all the spot of a project that owned by the student.
                $project->spots()->delete();
            });

            Project::where('ownerId' , $student->id)->delete();

            $student->skills()->detach();

            $student->requests()->delete();

            $student->spots()->each(function ($spot) {
                $spot->studentId = null;
                $spot->save();
            });

            EmailSender::sendStudentEmailAfterDeletingTheAccount($student);
        });
    }

    public function requestResetPasswordCode()
    {
        $this->resetPasswordCode = Str::random(16);
        $this->resetPasswordCodeValidUntil = now()->addSeconds(3600);
        $this->save();

        EmailSender::sendStudentEmailWithResetPasswordCode($this);
    }
}
