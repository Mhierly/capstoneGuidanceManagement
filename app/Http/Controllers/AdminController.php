<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mailer;
use App\Models\Appointments;
use App\Models\Concerns;
use App\Models\Student;
use Carbon\Carbon;
use DateTime;
use PDF;

class AdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     $response = $next($request);
        //     $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        //     $response->header('Pragma', 'no-cache');
        //     $response->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        //     return $response;
        // });
    }

    public function viewDashboard()
    {

        $no_of_report = DB::table('student_concern')->count();
        $no_of_drop = DB::table('drop_request')->where('isActive', '1')->count();
        $no_of_gm = DB::table('goodmoral_request')->where('isActive', '1')->count();

        $total_request = $no_of_report + $no_of_drop + $no_of_gm;

        $data['no_of_cases'] = DB::table('student_concern')->count();
        $data['no_of_request_forms'] = $total_request;
        $data['completed_appointments'] = DB::table('appointment_request')->where('status', 4)->count();
        $data['no_of_students'] = DB::table('students')->count();

        $events = [];

        $appointments = DB::table('appointment_request')->whereBetween('status', [3, 4])->get();

        foreach ($appointments as $appointment) {

            $student = DB::table('students')->where('id', $appointment->student_id)->first();
            $name = $student->firstname . ' ' . $student->lastname;
            $startDateTime = $appointment->appointment_date . ' ' . $appointment->appointment_time;
            $startTime = new DateTime($startDateTime);        // Parse start time
            $startDateTime = new DateTime($startDateTime);
            $endTime = $startTime->modify('+1 hour');
            $events[] = [
                'title' => 'Subject: ' . $appointment->subject,
                'start' => $startDateTime->format('Y-m-d\TH:i:s'),
                'end' => $endTime->format('Y-m-d\TH:i:s'),
            ];
        }
        // return $events;

        return view('admin.admin_dashboard', compact('data', 'events'));
    }

    public function viewStudentList()
    {
        $grade_levels = DB::table('grade_level')->get();
        $advisers = DB::table('advisers')->get();

        return view('admin.admin_studentList', ['grade_levels' => $grade_levels, 'advisers' => $advisers]);
    }
    function viewStudentListV2(Request $request)
    {
        try {
            $studentsList = Student::where('user_type', 2)->get();
            $student = [];
            $studentList = [];
            if ($request->student) {
                $student = Student::find($request->student);
            }
            foreach ($studentsList as $value) {
                $studentList[] = [
                    'id' => $value->id,
                    'name' => strtoupper($value->firstname . " " . $value->lastname),
                    'image' => $value->studentProfile(),
                    'email' => $value->account->email,
                    'status' => $this->checkUserAvailability($value->id)
                ];
            }
            //return $studentList;
            $grade_levels = DB::table('grade_level')->get();
            $advisers = DB::table('advisers')->get();

            return view('admin.studentListView', compact('studentList', 'student', 'grade_levels', 'advisers'));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    private function checkUserAvailability($id)
    {
        $student = Student::where('id', $id)->first();
        $status = true;
        if ($student) {
            $attributes = collect($student->getAttributes())->except('middlename', 'student_img', 'suffix', 'lrn', 'elem_school');
            if ($attributes->contains(function ($value) {
                return is_null($value);
            })) {
                $status = false;
            }
        }

        return $status;
    }
    public function viewCreateModule()
    {
        return view('admin.admin_createModule');
    }

    public function viewCOC()
    {
        return view('admin.admin_coc');
    }

    public function viewDropRequestList()
    {

        $this->autoUpdateDropRequestStatus();

        return view('admin.admin_dropRequestList');
    }

    private function autoUpdateDropRequestStatus()
    {
        // Get current date
        $today = Carbon::today();

        // Query all pending drop requests
        $pendingRequests = DB::table('drop_request')->where('status', '1')->get();

        foreach ($pendingRequests as $request) {
            // Parse the request date
            $requestDate = Carbon::parse($request->request_date)->startOfDay();

            // Check if the request date is before the current date
            if ($requestDate->lt($today)) {
                // Update the status to cancelled (2)
                DB::table('drop_request')
                    ->where('drop_request_id', $request->drop_request_id)
                    ->update(['status' => 2]);

                $student = DB::table('students')->where('id', $request->student_id)->first();

                $email_data = [
                    'subject' => 'Your drop request has been automatically canceled by the system',
                    'email_header' => 'Student drop request canceled',
                    'email_description' => 'Good day ' . ucwords($student->firstname) . '! Your drop request about "' . $request->reason . '" requested on ' . $request->request_date . ' has been automatically cancelled by the system. Please contact the guidance counselor if this is a mistake. Thank you!',
                    'email_notes' => '(Automatically canceled by the system)',
                ];

                $this->mailCancelUpdate($email_data, $student->email);
            }
        }

        $approveRequests = DB::table('drop_request')->where('status', '3')->get();

        foreach ($approveRequests as $request) {
            // Parse the request date
            $requestDate = Carbon::parse($request->request_date)->startOfDay();

            // Check if the request date is before the current date
            if ($requestDate->lt($today)) {
                // Update the status to cancelled (2)
                DB::table('drop_request')
                    ->where('drop_request_id', $request->drop_request_id)
                    ->update(['status' => 4]);
            }
        }
    }

    public function viewGoodMoralList()
    {

        $this->autoUpdateGoodMoralRequestStatus();

        return view('admin.admin_goodMoralList');
    }

    private function autoUpdateGoodMoralRequestStatus()
    {
        // Get current date
        $today = Carbon::today();

        // Query all pending drop requests
        $pendingRequests = DB::table('goodmoral_request')->where('status', '1')->get();

        foreach ($pendingRequests as $request) {
            // Parse the request date
            $requestDate = Carbon::parse($request->request_date)->startOfDay();

            // Check if the request date is before the current date
            if ($requestDate->lt($today)) {
                // Update the status to cancelled (2)
                DB::table('goodmoral_request')
                    ->where('request_id', $request->request_id)
                    ->update(['status' => 2]);

                $student = DB::table('students')->where('id', $request->student_id)->first();

                $email_data = [
                    'subject' => 'Your good moral request has been automatically canceled by the system',
                    'email_header' => 'Student good moral request canceled',
                    'email_description' => 'Good day ' . ucwords($student->firstname) . '! Your good moral request about "' . $request->reason . '" requested on ' . $request->request_date . ' has been automatically cancelled by the system. Please contact the guidance counselor if this is a mistake. Thank you!',
                    'email_notes' => '(Automatically canceled by the system)',
                ];

                $this->mailCancelUpdate($email_data, $student->email);
            }
        }

        $approveRequests = DB::table('goodmoral_request')->where('status', '3')->get();

        foreach ($approveRequests as $request) {
            // Parse the request date
            $requestDate = Carbon::parse($request->request_date)->startOfDay();

            // Check if the request date is before the current date
            if ($requestDate->lt($today)) {
                // Update the status to completed (4)
                DB::table('goodmoral_request')
                    ->where('request_id', $request->request_id)
                    ->update(['status' => 4]);
            }
        }
    }

    public function viewReports()
    {

        return view('admin.admin_reportList');
    }
    function viewReportsV2(Request $request)
    {
        $complainantList = Concerns::where('status', 1)
            ->join('students', 'student_concern.complainant_id', '=', 'students.id')
            ->select('student_concern.id as concern_id', 'student_concern.main_concern', 'students.firstName', 'students.lastName', 'students.id', 'student_concern.status')
            ->get();
        $complainantList = Concerns::where('status', 1)->with('student')->get();
        $concernList = [];

        foreach ($complainantList as $value) {
            $student = $value->student;

            $concernList[] = [
                'concern_id'      => $value->id,
                'main_concern'    => $value->main_concern,
                'complainant'     => $student ? strtoupper($student->firstname . " " . $student->lastname) : 'Unknown',
                'complainantImage' => $student ? $student->studentProfile() : null,
                'status'          => $value->status
            ];
        }
        $student = [];
        if ($request->view) {
            $data = Concerns::where('id', $request->view)->first();
            $student = $data->student;
        }
        //return $concernList;
        return view('admin.studentReportListView', compact('concernList', 'student'));
    }
    function generateConcern(Request $request)
    {
        $concernList = Concerns::whereBetween('status', [3, 4])->orderBy('created_at', 'asc')->get();
        $pdf = PDF::loadView('pdf_layout.concernList', compact('concernList'));
        $pdf->setPaper([0, 0, 612.00, 1008.00], 'portrait');
        return $pdf->stream('concernList.pdf');

        //return $pdf->download($filename);
    }
    public function viewAppointments(Request $request)
    {
        $this->autoUpdateAppointmentStatus();

        $events = [];

        $appointments = DB::table('appointment_request')->where('status', '3')->get();

        foreach ($appointments as $appointment) {

            $student = DB::table('students')->where('id', $appointment->student_id)->first();
            $name = $student->firstname . ' ' . $student->lastname;
            $events[] = [
                'title' => 'Subject: ' . $appointment->subject . ' (' . ucwords($name) . ' - ' . $student->email . ')',
                'start' => $appointment->appointment_date . ' ' . $appointment->appointment_time_from,
                'end' => $appointment->appointment_date . ' ' . $appointment->appointment_time_to,
            ];
        }
        $appointmentList = Appointments::select('appointment_request.*')
            ->join('students', 'students.id', '=', 'appointment_request.student_id')
            ->where('appointment_request.status', 1)
            ->whereOr('appointment_request.status', 3)
            ->orderBy('appointment_request.updated_at', 'desc')
            ->orderBy('appointment_request.status', 'asc')
            ->get();
        $student = [];
        if ($request->student) {
            $student = Appointments::where('appointment_id', $request->student)->first();
            $student = $student->student;
        }
        return view('admin.admin_appointmentList', compact('events', 'appointmentList', 'student'));
    }
    function viewAppointmentDetails(Request $request)
    {
        try {
            $appointment = Appointments::where('appointment_id', $request->value)->first();
            return response(compact('appointment'), 200);
        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()]);
        }
    }
    private function autoUpdateAppointmentStatus()
    {
        // Get current date and time
        $now = Carbon::now();

        // Query all pending appointments
        $pendingAppointments = DB::table('appointment_request')->where('status', '1')->get();

        foreach ($pendingAppointments as $appointment) {
            // Combine appointment date and time
            $appointmentDateTime = Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time);

            // Check if the appointment date and time is in the past
            if ($appointmentDateTime->lt($now)) {
                // Update the appointment status to cancelled (2)
                DB::table('appointment_request')
                    ->where('appointment_id', $appointment->appointment_id)
                    ->update(['status' => 2]);

                $student = DB::table('students')->where('id', $appointment->student_id)->first();

                $email_data = [
                    'subject' => 'Your appointment request has been automatically canceled by the system',
                    'email_header' => 'Student appointment request canceled',
                    'email_description' => 'Good day ' . ucwords($student->firstname) . '! Your appointment request about "' . $appointment->subject . '" requested on ' . $appointment->created_at . ' has been automatically cancelled by the system. Please contact the guidance counselor if this is a mistake. Thank you!',
                    'email_notes' => '(Automatically canceled by the system)',
                ];

                $this->mailCancelUpdate($email_data, $student->email);
            }
        }

        $approveAppointments = DB::table('appointment_request')->where('status', '3')->get();

        foreach ($approveAppointments as $appointment) {
            // Combine appointment date and time
            $appointmentDateTime = Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time);

            // Check if the appointment date and time is in the past
            if ($appointmentDateTime->lt($now)) {
                // Update the appointment status to completed (4)
                DB::table('appointment_request')
                    ->where('appointment_id', $appointment->appointment_id)
                    ->update(['status' => 4]);
            }
        }
    }

    public function viewForms()
    {
        return view('admin.admin_forms');
    }

    public function viewSrdRecords()
    {
        return view('admin.admin_srdRecords');
    }

    public function viewGoodMoralCert()
    {
        $students = DB::table('students')->get();

        $currentDate = Carbon::now();

        $info = [
            'school_year' => ($currentDate->year - 1) . '-' . $currentDate->year,
            'date_day' => $currentDate->format('j'), // Example: '6th'
            'date_day_superscript' => $currentDate->format('S'),
            'date_month' => $currentDate->format('F'), // Example: 'July'
            'date_year' => $currentDate->format('Y'), // Example: '2024'
            'current_date' => $currentDate->format('F j, Y'),
        ];


        return view('admin.request_forms.good_moral_cert', ['info' => $info, 'students' => $students]);
    }

    public function viewHomeVisitationForm()
    {
        $students = DB::table('students')->get();

        $currentDate = Carbon::now();

        $info = [
            'school_year' => ($currentDate->year - 1) . '-' . $currentDate->year,
            'date_day' => $currentDate->format('j'), // Example: '6th'
            'date_day_superscript' => $currentDate->format('S'),
            'date_month' => $currentDate->format('F'), // Example: 'July'
            'date_year' => $currentDate->format('Y'), // Example: '2024'
            'current_date' => $currentDate->format('F j, Y'),
        ];

        return view('admin.request_forms.home_visitation', ['info' => $info, 'students' => $students]);
    }

    public function viewReferralForm()
    {
        return view('admin.request_forms.referral_form');
    }
    public function viewTravelForm()
    {
        return view('admin.request_forms.travel_form');
    }
    public function viewAddAccount()
    {
        return view('admin.admin_add_account');
    }
    function viewAddAdviser()
    {
        $teacher = DB::table('advisers')->get();
        return view('admin.adminAddAdviser', compact('teacher'));
    }
    function addTeacher(Request $request)
    {
        try {
            DB::table('advisers')->insert([
                'adviser_name' => ucwords(strtolower($request->add_firstname . " " . $request->add_surname))
            ]);

            return back()->with(['success' => 'Saved']);
        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()]);
        }
    }
    private function mailCancelUpdate($data, $email)
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
