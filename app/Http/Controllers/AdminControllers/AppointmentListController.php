<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mailer;
use App\Models\Appointments;
use Exception;
use Carbon\Carbon;

class AppointmentListController extends Controller
{

    public function updateAppointmentStatus(Request $request)
    {
        $appointment = DB::table('appointment_request')->where('appointment_id', $request->input('appointment_id'))->first();
        $student = DB::table('students')->where('id', $appointment->student_id)->first();

        // Check if the appointment date is available
        if ($this->checkAppointmentAvailability($appointment)) {
            return response()->json('not available');
        }

        // Check if appointment can be approved
        if ($request->input('id') == 3 && !$this->checkAppointmentSchedule($appointment)) {
            return response()->json('overlap');
        }

        $status = DB::table('appointment_request')->where('appointment_id', $request->input('appointment_id'))->update(['status' => $request->input('id')]);

        if ($request->input('id') == 1) {
            $response = 'Appointment request has been updated into pending.';
        } else if ($request->input('id') == 2) {
            $response = 'Appointment request has been cancelled. Email sent to student';

            $email_data = [
                'subject' => 'Your appointment request has been cancelled by the counselor - Request Number (#' . $appointment->appointment_id . ')',
                'email_header' => 'Student appointment request cancelled',
                'email_description' => 'Good day ' . ucwords($student->firstname) . '! Your appointment request has been cancelled by the guidance counselor. Please contact the guidance counselor if this is a mistake. Thank you!',
                'email_notes' => '',
            ];

            $this->mailAppointmentUpdate($email_data, $student->email);
        } else if ($request->input('id') == 3) {
            $response = 'Appointment request has been approved. Email sent to student.';

            $email_data = [
                'subject' => 'Your appointment request has been approved by the counselor - Request Number (#' . $appointment->appointment_id . ')',
                'email_header' => 'Student appointment request approved',
                'email_description' => 'Good day ' . ucwords($student->firstname) . '! Your appointment request has been approved by the guidance counselor. Please check your account for more details of your appointment. Thank you!',
                'email_notes' => 'Schedule: ' . $appointment->appointment_date . ' (' . $appointment->appointment_time_from . ' - ' . $appointment->appointment_time_to . ')',
            ];

            $this->mailAppointmentUpdate($email_data, $student->email);
        } else if ($request->input('id') == 4) {
            $response = 'Appointment request marked as completed. Email sent to student';

            $email_data = [
                'subject' => 'Your appointment request has been completed by the counselor - Request Number (#' . $appointment->appointment_id . ')',
                'email_header' => 'Student appointment request completed',
                'email_description' => 'Good day ' . ucwords($student->firstname) . '! Your appointment request has been completed by the guidance counselor. Please contact the guidance counselor if this is a mistake. Thank you!',
                'email_notes' => '',
            ];

            $this->mailAppointmentUpdate($email_data, $student->email);
        }

        if ($status) {
            $update_time = DB::table('appointment_request')->where('appointment_id', $request->input('appointment_id'))->update(['updated_at' => now()]);
            return response()->json($response);
        } else {
            return response()->json('Error update.');
        }
    }

    private function checkAppointmentSchedule($appointment)
    {
        // Get the start and end time of the current appointment
        $startTime = Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time);
        $endTime = $startTime->copy()->addHour(); // assuming appointments are 1 hour long

        // Check for overlapping appointments
        $overlappingAppointment = DB::table('appointment_request')
            ->where('status', 3) // Approved appointments
            ->where('appointment_date', $appointment->appointment_date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($query) use ($startTime, $endTime) {
                    $query->whereBetween('appointment_time', [$startTime->format('H:i:s'), $endTime->format('H:i:s')]);
                })
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('appointment_time', '<', $startTime->format('H:i:s'))
                            ->where(DB::raw('ADDTIME(appointment_time, "01:00:00")'), '>', $startTime->format('H:i:s'));
                    });
            })
            ->first();

        return $overlappingAppointment ? false : true;
    }

    private function checkAppointmentAvailability($appointment)
    {
        // Get current date and time
        $now = Carbon::now();
        // Get appointment date and time
        $appointmentDateTime = Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time);

        return $appointmentDateTime->lt($now); // Check if the appointment date and time is less than the current date and time
    }


    public function emailAppointment(Request $request)
    {
        $appointment = DB::table('appointment_request')->where('appointment_id', $request->input('id'))->first();
        $student = DB::table('students')->where('id', $appointment->student_id)->first();

        $email_data = [
            'subject' => 'Reminder about your appointment schedule - Request Number (#' . $appointment->appointment_id . ')',
            'email_header' => 'Appointment schedule reminder!',
            'email_description' => 'Good day ' . ucwords($student->firstname) . '! This is a reminder for your scheduled appointment. Please check your account for more details of your appointment. Thank you!',
            'email_notes' => 'Schedule: ' . $appointment->appointment_date . ' (' . $appointment->appointment_time_from . ' - ' . $appointment->appointment_time_to . ')',
        ];

        try {
            $this->mailAppointmentUpdate($email_data, $student->email);
            return response()->json('Email sent to student!');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function removeAppointmentItem(Request $request)
    {
        $status = DB::table('appointment_request')->where('appointment_id', $request->input('id'))->delete();

        if ($status) {
            return response()->json('Appointment request has been deleted.');
        } else {
            return response()->json('Error');
        }
    }
    function scheduledAppointment(Request $request)
    {
        $request->validate([
            'appointmentDate' => 'required',
            'appointmentTime' => 'required'
        ]);
        try {
            $appointmentData = Appointments::where('appointment_id', $request->appointmentID)->first();
            if ($appointmentData) {
                // Check Scheduled
                $appointmentScheduled = Appointments::where('appointment_date', $request->appointmentDate)
                    ->where('appointment_time', $request->appointmentTime)
                    ->get();
                if (count($appointmentScheduled) > 0) {
                    return back()->with(['error' => 'This schedule is already taken. Please select a different one.']);
                } else {
                    $appointmentData->where('appointment_id', $request->appointmentID)
                        ->update([
                            'appointment_date' => $request->appointmentDate,
                            'appointment_time' => $request->appointmentTime,
                            'status' => 3
                        ]);
                    return back()->with(['success' => 'Approved Appointment Scheduled']);
                }
            } else {
                return back()->with(['error' => 'Missing Id']);
            }
        } catch (\Throwable $th) {
            //return back()->with(['error' => $th->getMessage()]);
            return $th->getMessage();
        }
    }
    function durationAppointment(Request $request)
    {
        $request->validate([
            'appointment_time_from' => 'required',
            'appointment_time_to' => 'required'
        ]);
        try {
            $appointmentData = Appointments::where('appointment_id', $request->appointmentID)->first();
            if ($appointmentData) {
                $appointmentData->where('appointment_id', $request->appointmentID)
                    ->update([
                        'appointment_time_from' => $request->appointment_time_from,
                        'appointment_time_to' => $request->appointment_time_to,
                        'status' => 4
                    ]);
                return back()->with(['success' => 'Complete Session']);
            } else {
                return ['error' => 'Missing Id'];
                return back()->with(['error' => 'Missing Id']);
            }
        } catch (\Throwable $th) {
            return back()->with(['error' => $th->getMessage()]);
            return $th->getMessage();
        }
    }
    function fetchAppointment(Request $request)
    {
        try {
            $appointmentList1 = Appointments::where('status', $request->status)->orderBy('appointment_id', 'desc')->get();
            $appointmentList = [];
            foreach ($appointmentList1 as $key => $appointment) {
                $appointmentList[] = array(
                    'appointment_id' => $appointment->appointment_id,
                    'appointment_subject' => $appointment->subject,
                    'appointment_reason' => $appointment->reason,
                    'appointment_status' => $appointment->status,
                    'name' => strtoupper($appointment->student->lastname . ", " . $appointment->student->firstname),
                    'image' => $appointment->student->studentProfile()
                );
            }
            return response(compact('appointmentList'), 200);
        } catch (\Throwable $th) {
            return response([
                'message' => $th->getMessage()
            ], 500);
        }
    }
    private function mailAppointmentUpdate($data, $email)
    {
        $layout = 'mail_layout.request_update_email';
        $subject = $data['subject'];

        try {
            Mail::to($email)->send(new Mailer($data, $layout, $subject));
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
