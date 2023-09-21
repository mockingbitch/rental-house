<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherInformation extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'teacher_informations';

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'teacher_id',
        'first_name',
        'last_name',
        'email',
        'birthday',
        'country_code',
        'country_id',
        'city_id',
        'phone',
        'headline',
        'about',
        'introduction_video',
        'bank_name',
        'branch_code',
        'account_type',
        'account_number',
        'account_name',
        'stripe_account_id',
        'profile_image',
        'card_image_front',
        'card_image_back',
        'school',
        'major',
        'major_specialize',
        'admission_date',
        'graduation_date',
        'academic_certificate',
        'job',
        'salary',
        'step',
        'status',
    ];
}
