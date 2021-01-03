<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The spots that has a rule.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spots()
    {
        return $this->hasMany('App\Models\Spot', 'roleId', 'id');
    }
}
