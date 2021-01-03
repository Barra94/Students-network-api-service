<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Endorsement extends Model
{
    use HasFactory, Notifiable;

    public $incrementing = false;

    protected $primaryKey = ['studentId', 'skillId', 'endorserId'];

    protected $table = 'endorsement';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['studentId', 'skillId', 'endorserId'];

    /**
     * Return the skill owner of the endorsement.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function skillOwner()
    {
        return $this->belongsTo(Student::class, 'studentId','id');
    }

    /**
     * Return the skill of the endorsement.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skillId','id');
    }

    /**
     * Return the endorse of this skill endorsement.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function endorser()
    {
        return $this->belongsTo(Student::class, 'endorserId','id');
    }
}