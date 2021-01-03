<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id';

    protected $table = 'project';

    /**
     * Get owner of the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(Student::class,'ownerId', 'id');
    }

    /**
     * Get the spots of a project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spots()
    {
        return $this->hasMany(Spot::class, 'projectId', 'id');
    }
}
