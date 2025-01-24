<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppController extends Controller
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
    protected function getStudentData($user_id)
    {
        return $student = Student::where('user_id', $user_id)->first();
    }

    public function viewDashboard()
    {
        $status = $this->checkIfDrop();

        return view('user.user_home', ['status' => $status]);
    }

    public function viewReportForm()
    {
        $student = Student::where('user_id', Auth::user()->id)->first();
        $grades = DB::table('grade_level')->get();
        $advisers = DB::table('advisers')->get();
        $status = $this->checkUserAvailability();

        return view('user.user_report_form', ['student' => $student, 'grades' => $grades, 'advisers' => $advisers, 'status' => $status]);
    }

    public function viewAppointments()
    {
        return view('user.user_appointments');
    }

    public function viewCOC()
    {
        return view('user.user_coc');
    }

    public function viewProfile()
    {
        $student = Student::where('user_id', Auth::user()->id)->first();

        $profile_img = $student->student_img == null ? asset('img/default.jpg') : route('student.image', ['id' => $student->id]);
        $grade_levels = DB::table('grade_level')->get();
        $sections = DB::table('sections')->get();
        $advisers = DB::table('advisers')->get();

        $current_grade = DB::table('grade_level')->where('id', $student->current_grade)->value('grade_level');
        $current_section = DB::table('sections')->where('id', $student->current_section)->value('section_name');
        $adviser = DB::table('advisers')->where('id', $student->adviser)->value('adviser_name');
        $formattedDate = Carbon::createFromFormat('Y-m-d', $student->birthday)->format('F j, Y');

        $birthDateCarbon = Carbon::createFromFormat('Y-m-d', $student->birthday);

        $currentDate = Carbon::now();
        $currentYear = $currentDate->format('y');
        $student_age = $birthDateCarbon->diffInYears($currentDate);

        $student_address = [
            'province' => DB::table('philippine_provinces')->where('province_code', $student->province)->value('province_description') ?? '(UPDATE)',
            'city' => DB::table('philippine_cities')->where('city_municipality_code', $student->municipality)->value('city_municipality_description') ?? '(UPDATE)',
            'barangay' => DB::table('philippine_barangays')->where('barangay_code', $student->baranggay)->value('barangay_description') ?? '(UPDATE)',
        ];

        return view(
            'user.user_profile',
            [
                'profile_img' => $profile_img,
                'student' => $student,
                'student_address' => $student_address,
                'current_grade' => $current_grade,
                'current_section' => $current_section,
                'formatted_date' => $formattedDate,
                'student_age' => $student_age,
                'current_year' => $currentYear,
                'adviser' => $adviser,
                'grade_levels' => $grade_levels,
                'sections' => $sections,
                'advisers' => $advisers
            ]
        );
    }
    function viewProfileV2()
    {
        try {
            $nationalities = array(
                'Afghan',
                'Albanian',
                'Algerian',
                'American',
                'Andorran',
                'Angolan',
                'Antiguans',
                'Argentinean',
                'Armenian',
                'Australian',
                'Austrian',
                'Azerbaijani',
                'Bahamian',
                'Bahraini',
                'Bangladeshi',
                'Barbadian',
                'Barbudans',
                'Batswana',
                'Belarusian',
                'Belgian',
                'Belizean',
                'Beninese',
                'Bhutanese',
                'Bolivian',
                'Bosnian',
                'Brazilian',
                'British',
                'Bruneian',
                'Bulgarian',
                'Burkinabe',
                'Burmese',
                'Burundian',
                'Cambodian',
                'Cameroonian',
                'Canadian',
                'Cape Verdean',
                'Central African',
                'Chadian',
                'Chilean',
                'Chinese',
                'Colombian',
                'Comoran',
                'Congolese',
                'Costa Rican',
                'Croatian',
                'Cuban',
                'Cypriot',
                'Czech',
                'Danish',
                'Djibouti',
                'Dominican',
                'Dutch',
                'East Timorese',
                'Ecuadorean',
                'Egyptian',
                'Emirian',
                'Equatorial Guinean',
                'Eritrean',
                'Estonian',
                'Ethiopian',
                'Fijian',
                'Filipino',
                'Finnish',
                'French',
                'Gabonese',
                'Gambian',
                'Georgian',
                'German',
                'Ghanaian',
                'Greek',
                'Grenadian',
                'Guatemalan',
                'Guinea-Bissauan',
                'Guinean',
                'Guyanese',
                'Haitian',
                'Herzegovinian',
                'Honduran',
                'Hungarian',
                'Icelander',
                'Indian',
                'Indonesian',
                'Iranian',
                'Iraqi',
                'Irish',
                'Israeli',
                'Italian',
                'Ivorian',
                'Jamaican',
                'Japanese',
                'Jordanian',
                'Kazakhstani',
                'Kenyan',
                'Kittian and Nevisian',
                'Kuwaiti',
                'Kyrgyz',
                'Laotian',
                'Latvian',
                'Lebanese',
                'Liberian',
                'Libyan',
                'Liechtensteiner',
                'Lithuanian',
                'Luxembourger',
                'Macedonian',
                'Malagasy',
                'Malawian',
                'Malaysian',
                'Maldivan',
                'Malian',
                'Maltese',
                'Marshallese',
                'Mauritanian',
                'Mauritian',
                'Mexican',
                'Micronesian',
                'Moldovan',
                'Monacan',
                'Mongolian',
                'Moroccan',
                'Mosotho',
                'Motswana',
                'Mozambican',
                'Namibian',
                'Nauruan',
                'Nepalese',
                'New Zealander',
                'Nicaraguan',
                'Nigerian',
                'Nigerien',
                'North Korean',
                'Northern Irish',
                'Norwegian',
                'Omani',
                'Pakistani',
                'Palauan',
                'Panamanian',
                'Papua New Guinean',
                'Paraguayan',
                'Peruvian',
                'Polish',
                'Portuguese',
                'Qatari',
                'Romanian',
                'Russian',
                'Rwandan',
                'Saint Lucian',
                'Salvadoran',
                'Samoan',
                'San Marinese',
                'Sao Tomean',
                'Saudi',
                'Scottish',
                'Senegalese',
                'Serbian',
                'Seychellois',
                'Sierra Leonean',
                'Singaporean',
                'Slovakian',
                'Slovenian',
                'Solomon Islander',
                'Somali',
                'South African',
                'South Korean',
                'Spanish',
                'Sri Lankan',
                'Sudanese',
                'Surinamer',
                'Swazi',
                'Swedish',
                'Swiss',
                'Syrian',
                'Taiwanese',
                'Tajik',
                'Tanzanian',
                'Thai',
                'Togolese',
                'Tongan',
                'Trinidadian or Tobagonian',
                'Tunisian',
                'Turkish',
                'Tuvaluan',
                'Ugandan',
                'Ukrainian',
                'Uruguayan',
                'Uzbekistani',
                'Venezuelan',
                'Vietnamese',
                'Welsh',
                'Yemenite',
                'Zambian',
                'Zimbabwean',
            );
            $religions = [
                'Buddhism',
                'Christian',
                'Hinduism',
                'Islam',
                'Judaism',
                'Sikhism',
                'Atheism',
                'Agnosticism',
                "Bahá'í",
                'Confucianism',
                'Jainism',
                'Shinto',
                'Taoism',
                'Zoroastrianism',
                'Rastafarianism',
                'Scientology',
                'Unitarian Universalism',
                'Paganism',
                'Animism',
                'Other',
            ];

            $student = Student::where('user_id', Auth::user()->id)->first();
            $student_address = [
                'province' => DB::table('philippine_provinces')->where('province_code', $student->province)->value('province_description') ?? '(UPDATE)',
                'city' => DB::table('philippine_cities')->where('city_municipality_code', $student->municipality)->value('city_municipality_description') ?? '(UPDATE)',
                'barangay' => DB::table('philippine_barangays')->where('barangay_code', $student->baranggay)->value('barangay_description') ?? '(UPDATE)',
            ];
            $province =  DB::table('philippine_provinces')->get();
            return view('user.userProfileView', compact('student', 'nationalities', 'religions', 'student_address', 'province'));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    function viewForm()
    {
        $status = $this->checkUserAvailability();
        $subjects = array(
            'Academic Concerns',
            'Career Planning',
            'Personal Issues',
            'Behavioral Support',
            'Policies & Procedures',
            'Specialized Support',
        );
        $student = $this->getStudentData(Auth::user()->id);
        $appointments = [];
        $goodMoral = [];
        $dropList = [];
        if ($student) {
            //return $student;
            $appointments = $student->listOfAppoitments;
            $dropList = $student->dropRequest;
        } else {
            return redirect(route('user.viewProfile'));
        }
        return view('user.request_forms.request_forms', compact('status', 'subjects', 'appointments', 'dropList'));
    }
    public function viewFormAppointment()
    {
        $status = $this->checkUserAvailability();

        return view('user.request_forms.request_appointment', ['status' => $status]);
    }

    public function viewFormDrop()
    {
        $status = $this->checkUserAvailability();

        return view('user.request_forms.request_dropform', ['status' => $status]);
    }

    public function viewFormMoral()
    {
        $status = $this->checkUserAvailability();

        return view('user.request_forms.request_goodmoral', ['status' => $status]);
    }

    private function checkUserAvailability()
    {
        $student = Student::where('user_id', Auth::user()->id)->first();
        $status = "Complete";
        if ($student) {
            $attributes = collect($student->getAttributes())->except('middlename', 'suffix', 'lrn', 'elem_school');
            if ($attributes->contains(function ($value) {
                return is_null($value);
            })) {
                $status = 'Incomplete';
            }
        }

        return $status;
    }

    private function checkIfDrop()
    {
        $student = Student::where('user_id', Auth::user()->id)->first();
        $status = true;
        if ($student) {
            $status = $student->student_status;
        }
        return $status;
    }

    public function getProvinces()
    {
        $provinces = DB::table('philippine_provinces')->get();

        return response()->json($provinces);
    }

    public function getCities($province_code)
    {
        $cities = DB::table('philippine_cities')->where('province_code', $province_code)->get();

        return response()->json($cities);
    }

    public function getBarangays($province_code, $city_code)
    {
        $barangays = DB::table('philippine_barangays')->where('province_code', $province_code)->where('city_municipality_code', $city_code)->get();

        return response()->json($barangays);
    }

    public function getSections($grade_id)
    {
        $sections = DB::table('sections')->where('grade_id', $grade_id)->get();

        return response()->json($sections);
    }
}
