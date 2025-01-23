<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';

    protected $fillable = [
        'user_type',
        'student_img',
        'user_id',
        'firstname',
        'middlename',
        'lastname',
        'email',
        'suffix',
        'lrn',
        'house_no_street',
        'baranggay',
        'municipality',
        'province',
        'contact_no',
        'birthday',
        'sex',
        'nationality',
        'religion',
        'father',
        'father_occupation',
        'mother',
        'mother_occupation',
        'living_with',
        'no_of_siblings',
        'position',
        'elem_school',
        'school_id',
        'gen_average',
        'current_grade',
        'current_section',
        'adviser',
        'student_status',
    ];
    function listOfAppoitments()
    {
        return $this->hasMany(Appointments::class, 'student_id')->orderBy('status', 'desc')->orderBy('appointment_id', 'desc');
    }
    function dropRequest()
    {
        return $this->hasMany(Drops::class, 'student_id')->orderBy('status', 'desc')->orderBy('drop_request_id', 'desc');
    }
}


// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;

// class Student extends Authenticatable
// {
//     use HasFactory, Notifiable;

//     public $timestamps = false;

//     protected $fillable = [
//         'firstname', 'lastname', 'email', 'password',
//     ];

//     protected $hidden = [
//         'password', 'remember_token',
//     ];
// }
