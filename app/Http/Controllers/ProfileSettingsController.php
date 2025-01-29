<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileSettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware example (optional)
        // $this->middleware(function ($request, $next) {
        //     $response = $next($request);
        //     $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        //     $response->header('Pragma', 'no-cache');
        //     $response->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        //     return $response;
        // });
    }

    public function profile_editor(Request $request)
    {
        $student_id = DB::table('students')->where('user_id', Auth::user()->id)->value('id');
        $check_email = DB::table('students')->where('id', $student_id)->value('email');

        if ($request->file('profile_img') == NULL) {
            $studentData = [
                'email' => $request->input('profile_email'),
                'firstname' => $request->input('profile_first_name'),
                'middlename' => $request->input('profile_middle_name'),
                'lastname' => $request->input('profile_last_name'),
                'suffix' => $request->input('profile_suffix'),
                'contact_no' => $request->input('profile_contact'),
                'birthday' => $request->input('profile_birthdate'),
                'sex' => $request->input('profile_gender'),
                'house_no_street' => $request->input('profile_street'),
                'baranggay' => $request->input('profile_baranggay'),
                'municipality' => $request->input('profile_municipality'),
                'province' => $request->input('profile_province'),
                'nationality' => $request->input('profile_nationality'),
                'religion' => $request->input('profile_religion'),
                'father' => $request->input('profile_father'),
                'emergency_contact' => $request->input('emergency_contact'),
                'father_occupation' => $request->input('profile_father_occupation'),
                'mother' => $request->input('profile_mother'),
                'mother_occupation' => $request->input('profile_mother_occupation'),
                'living_with' => $request->input('living_with'),
                'no_of_siblings' => $request->input('profile_no_sibling'),
                'position' => $request->input('profile_sibling_position'),
            ];

            $profile_status = false;
        } else {
            $image = Image::make($request->file('profile_img'))
                ->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode('jpg', 75); // Resize and compress image

            $studentData = [
                'student_img' => $image,
                'email' => $request->input('profile_email'),
                'firstname' => $request->input('profile_first_name'),
                'middlename' => $request->input('profile_middle_name'),
                'lastname' => $request->input('profile_last_name'),
                'suffix' => $request->input('profile_suffix'),
                'contact_no' => $request->input('profile_contact'),
                'birthday' => $request->input('profile_birthdate'),
                'sex' => $request->input('profile_gender'),
                'house_no_street' => $request->input('profile_street'),
                'baranggay' => $request->input('profile_baranggay'),
                'municipality' => $request->input('profile_municipality'),
                'province' => $request->input('profile_province'),
                'nationality' => $request->input('profile_nationality'),
                'religion' => $request->input('profile_religion'),
                'father' => $request->input('profile_father'),
                'father_occupation' => $request->input('profile_father_occupation'),
                'mother' => $request->input('profile_mother'),
                'mother_occupation' => $request->input('profile_mother_occupation'),
                'living_with' => $request->input('living_with'),
                'no_of_siblings' => $request->input('profile_no_sibling'),
                'position' => $request->input('profile_sibling_position'),
            ];

            $profile_status = true;
        }

        try {
            $status = DB::table('students')->where('id', $student_id)->update($studentData);
        } catch (Exception $e) {
            return redirect()->back()->with('error_update', 'Profile update failed!');
        }

        if ($status || $profile_status) {
            if ($check_email != $request->input('profile_email')) {
                $update_user_email = DB::table('users')->where('id', Auth::user()->id)->update(['email' => $request->input('profile_email')]);

                if (!$update_user_email) {
                    return redirect()->back()->with('error_update', 'Profile update failed!');
                }
            }

            DB::table('students')->where('id', $student_id)->update(['updated_at' => now()]);
            return redirect()->back()->with('status_update', 'Profile updated successfully!');
        } else {
            return redirect()->back()->with('status_no_update', 'No changes made.');
        }
    }

    public function profile_editor2(Request $request)
    {
        $student_id = DB::table('students')->where('user_id', Auth::user()->id)->value('id');

        $studentData = [
            'lrn' => $request->input('lrn'),
            'elem_school' => $request->input('elem_school'),
            'gen_average' => $request->input('gen_average'),
            'current_grade' => $request->input('current_grade_options'),
            'current_section' => $request->input('current_section_options'),
            'adviser' => $request->input('adviser')
        ];
        try {

            $status = DB::table('students')->where('id', $student_id)->update($studentData);
            $user = User::find(Auth::user()->id);
            $user->username = $request->lrn;
            $user->save();
        } catch (\Throwable $e) {

            return redirect()->back()->with('error_update', 'Profile update failed!' . '\nError: ' . $e->getMessage());
        }

        if ($status) {

            DB::table('students')->where('id', $student_id)->update(['updated_at' => now()]);
            return redirect()->back()->with('status_update', 'Profile updated successfully!');
        } else {
            return redirect()->back()->with('status_no_update', 'No changes made.');
        }
    }
    function profileEditor2(Request $request)
    {
        $request->validate([
            'student_profile' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'birthdate' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'religion' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'province' => 'required',
            'municipality' => 'required',
            'baranggay' => 'required',
            'father' => 'required',
            'father_occupation' => 'required',
            'mother' => 'required',
            'mother_occupation' => 'required',
            'living_with' => 'required',
            'no_of_siblings' => 'required',
            'position' => 'required',
            'emergency_contact' => 'required'
        ]);
        try {
            $account = Auth::user()->student;
            $imageFile = $this->saveImage($request->file('student_profile'), 'public', 'profileImage');
            $studentData = array(
                'student_img' => $imageFile,
                'email' => $request->input('email'),
                'firstname' => ucwords(strtolower(trim($request->input('first_name')))),
                'middlename' =>  ucwords(strtolower(trim($request->input('middle_name')))),
                'lastname' =>  ucwords(strtolower(trim($request->input('last_name')))),
                'suffix' => $request->input('suffix'),
                'contact_no' => $request->input('contact'),
                'birthday' => $request->input('birthdate'),
                'sex' => $request->input('gender'),
                'house_no_street' => ucwords(strtolower(trim($request->input('street')))),
                'baranggay' => $request->input('baranggay'),
                'municipality' => $request->input('municipality'),
                'province' => $request->input('province'),
                'nationality' => $request->input('nationality'),
                'religion' => $request->input('religion'),
                'father' => ucwords(strtolower(trim($request->input('father')))),
                'father_occupation' => ucwords(strtolower(trim($request->input('father_occupation')))),
                'mother' => ucwords(strtolower(trim($request->input('mother')))),
                'mother_occupation' => ucwords(strtolower(trim($request->input('mother_occupation')))),
                'living_with' => $request->input('living_with'),
                'no_of_siblings' => $request->input('no_of_siblings'),
                'position' => $request->input('position'),
                'emergency_contact' => $request->emergency_contact
            );
            // Student::find()->update()
            $account->update($studentData);
            return redirect(route('user.viewProfileV2'))->with('success', 'Profile updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
