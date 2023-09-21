<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherWorkHistory extends Model
{
    use HasFactory;
    
    /**
     * @var string
     */
    protected $table = 'teacher_work_histories';

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'teacher_id',
        'work_position',
        'recruitment_form',
        'company',
        'work_start_date',
        'work_end_date',
        'is_still_working',
    ];
}
