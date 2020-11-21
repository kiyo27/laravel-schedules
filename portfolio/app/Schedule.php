<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';

    protected $primaryKey = 'id';

    protected $fillable = [
        'owner',
        'due_date',
        'title',
        'description',
    ];
}
