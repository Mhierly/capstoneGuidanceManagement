@extends('pdf_layout.pdfLayout')
@section('page-content')
    <h2 style="align-content: center; text-align:center"><b>STUDENT INFORMATION</b></h2>
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="{{ $studentImage }}" alt="Student Image" width="120" height="120" style="object-fit: cover;">
    </div>
    <table class="profile-table">
        <tr>
            <td>
                <label for="name">Name: <span>{{ $student->firstname . ' ' . $student->lastname }}</span></label>
            </td>
            <td>
                <label for="lrn">LRN: <span>{{ $student->lrn }}</span></label>
            </td>
        </tr>
        <tr>
            <td>
                <label for="address">Address: <span>{{ $house_no_street }}, {{ $baranggay }}, {{ $municipality }},
                        {{ $province }}</span></label>
            </td>
            <td>
                <label for="contact">Contact No: <span>{{ $contact_no }}</span></label>
            </td>
        </tr>
        <tr>
            <td>
                <label for="birthday">Birthday: <span>{{ $birthday }}</span></label>
            </td>
            <td>
                <label for="age">Age: <span>{{ $age }}</span></label>
                <label for="sex">Sex: <span>{{ $sex }}</span></label>
            </td>
        </tr>
        <tr>
            <td>
                <label for="nationality">Nationality: <span>{{ $nationality }}</span></label>
            </td>
            <td>
                <label for="religion">Religion: <span>{{ $religion }}</span></label>
            </td>
        </tr>
        <tr>
            <td>
                <label for="father">Father: <span>{{ $father }}</span></label>
            </td>
            <td>
                <label for="father-occupation">Occupation: <span>{{ $father_occupation }}</span></label>
            </td>
        </tr>
        <tr>
            <td>
                <label for="mother">Mother: <span>{{ $mother }}</span></label>
            </td>
            <td>
                <label for="mother-occupation">Occupation: <span>{{ $mother_occupation }}</span></label>
            </td>
        </tr>
        <tr>
            <td>
                <label for="living-with">Living with whom: <span>{{ $living_with }}</span></label>
            </td>
            <td>
                <label for="siblings">No. of siblings: <span>{{ $no_of_siblings }}</span></label>
                <label style="float: right" for="position">Position: <span>{{ $position }}</span></label>
            </td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center;">EDUCATIONAL BACKGROUND</th>
        </tr>
        <tr>
            <td colspan="2">
                <label for="elementary">Elementary School Graduate: <span>{{ $elem_school }}</span></label>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label for="grade-level">Last Grade Level Completed: <span>{{ $last_grade }}</span></label>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label for="school-address">School Address: <span>{{ 'BNHS-SINIPIT,BONGABON,N.E' }}</span></label>
                <label for="school-id" style="float: right">School ID: <span>{{ $school_id }}</span></label>
            </td>
        </tr>
        <tr>
            <td>
                <label for="school-year">School Year:</label>
            </td>
            <td>
                <label for="gen-ave">Gen. Ave: <span>{{ $gen_average }}</span></label>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label for="grade-section">Grade Level & Section: <span>{{ $current_grade }} -
                        {{ $current_section }}</span></label>
            </td>
        </tr>
        <tr>
            <td>
                <label for="next-school-year">School Year:</label>
            </td>
            <td>
                <label for="adviser">Adviser: <span>{{ $adviser }}</span></label>
            </td>
        </tr>
    </table>
@endsection
