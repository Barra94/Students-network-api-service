<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'skill';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'type'];

    /**
     * The students with a skill.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany('App\Models\Student', 'student_skill', 'skillId','studentId');
    }

    /**
     * The spots of a skill.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function spots()
    {
        return $this->belongsToMany('App\Models\Skill', 'skill_spot', 'skillId','spotId');
    }

    /**
     * The endorsements of the skill.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function endorsements()
    {
        return $this->hasMany(Endorsement::class, 'skillId', 'id');
    }
}
