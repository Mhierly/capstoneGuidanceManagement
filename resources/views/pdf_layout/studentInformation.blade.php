@extends('pdf_layout.pdfLayout')
@section('page-content')
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            /* padding: 5px; */
            text-align: left;
        }

        .profile-container {
            background-color: transparent;
            border-radius: 15px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h3,
        .header h4 {
            margin: 5px 0;
        }

        img {
            width: 100px;
            height: auto;
        }

        @media print {
            .profile-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
                border-radius: 0;
            }

            .profile-table td input {
                border: none;
                border-bottom: 1px solid #000;
            }
        }

        table {
            width: 100%;
            table-layout: fixed;
        }

        td {
            width: 50%;
            padding: 10px;
            border-color: #6cbe1a;
        }

        th {
            border-color: #6cbe1a;
        }

        input[type="text"] {
            width: 80%;
            box-sizing: border-box;
        }

        span {
            font-weight: bold;
            text-transform: capitalize;
        }
    </style>
    <div class="profile-container">
        <h2 style="align-content: center; text-align:center"><b>STUDENT INFORMATION</b></h2>
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ $studentImage }}" alt="Student Image" width="120" height="120" style="object-fit: cover;">
        </div>
        <table class="profile-table">
            <tr>
                <td>
                    <label for="name">Name:
                        <span>{{ $student->firstname . ' ' . $student->middlename . ' ' . $student->lastname . ' ' . $student->suffix }}</span></label>
                </td>
                <td>
                    <label for="lrn">LRN: <span>{{ $student->lrn }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="address">Address:
                        <span>
                            {{ $student->house_no_street }},
                            {{ $student->barangay() ? $student->barangay()->barangay_description : '' }},
                            {{ $student->municipality() ? $student->municipality()->city_municipality_description : '' }},
                            {{ $student->province() ? $student->province()->province_description : '' }}
                        </span>
                    </label>
                </td>
                <td>
                    <label for="contact">Contact No: <span>{{ $student->contact_no }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="birthday">Birthday: <span>{{ $student->birthday }}</span></label>
                </td>
                <td>
                    <label for="age">Age: <span>{{ $student->age }}</span></label>
                    <label for="sex">Sex: <span>{{ $student->sex }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="nationality">Nationality: <span>{{ $student->nationality }}</span></label>
                </td>
                <td>
                    <label for="religion">Religion: <span>{{ $student->religion }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="father">Father: <span>{{ $student->father }}</span></label>
                </td>
                <td>
                    <label for="father-occupation">Occupation: <span>{{ $student->father_occupation }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mother">Mother: <span>{{ $student->mother }}</span></label>
                </td>
                <td>
                    <label for="mother-occupation">Occupation: <span>{{ $student->mother_occupation }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="living-with">Living with whom: <span>{{ $student->living_with }}</span></label>
                </td>
                <td>
                    <label for="siblings">No. of siblings: <span>{{ $student->no_of_siblings }}</span></label>
                    <label style="float: right" for="position">Position: <span>{{ $student->position }}</span></label>
                </td>
            </tr>
            <tr>
                <th colspan="2" style="text-align: center;">EDUCATIONAL BACKGROUND</th>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="elementary">Elementary School Graduate: <span>{{ $student->elem_school }}</span></label>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="grade-level">Last Grade Level Completed: <span>{{ $student->last_grade }}</span></label>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="school-address">School Address: <span>{{ 'BNHS-SINIPIT,BONGABON,N.E' }}</span></label>
                    <label for="school-id" style="float: right">School ID: <span>{{ $student->school_id }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="school-year">School Year:</label>
                </td>
                <td>
                    <label for="gen-ave">Gen. Ave: <span>{{ $student->gen_average }}</span></label>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="grade-section">Grade Level & Section:
                        <span>{{ $student->yearLevel() ? $student->yearLevel()->grade_level : '' }} -
                            {{ $student->section() ? $student->section()->section_name : '' }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="next-school-year">School Year:</label>
                </td>
                <td>
                    <label for="adviser">Adviser:
                        <span>{{ $student->adviser() ? $student->adviser()->adviser_name : '' }}</span></label>
                </td>
            </tr>
        </table>
    </div>
@endsection
