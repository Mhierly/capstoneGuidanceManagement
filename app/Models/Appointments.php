<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;

    protected $table = 'appointment_request';

    protected $fillable = [
        'request_type',
        'student_id',
        'appointment_date',
        'appointment_time',
        'appointment_time_from',
        'appointment_time_to',
        'duration',
        'subject',
        'status',
        'reason',
        'counselor_id',
    ];

    function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
