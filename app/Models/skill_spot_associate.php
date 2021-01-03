<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class skill_spot_associate extends Model{
    use HasFactory;

    protected $table = 'skill_spot_associate';

    protected $primaryKey = 'id';
}
