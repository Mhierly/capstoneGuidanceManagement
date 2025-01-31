@extends('pdf_layout.pdfLayout')
@section('page-content')
    <div class="title">
        <h5><b>I. IDENTIFYING INFORMATION</b></h5>
    </div>
    <div class="table-title">
        <h5><b>A. VICTIM</b></h5>
    </div>
    <div class="table-container">
        <table>
            <tr>
                <td>Name: <span id="victim_name" style="width: 273px;">{{ $concern->victim_name }}</span></td>
                <td>Signature: <span
                        style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </td>
            </tr>
            <tr>
                <td>Age: <span id="victim_age" style="width: 285px;">{{ $concern->victim_age }}</span></td>
                <td>Gender: <span id="victim_gender" style="width: 215px;">{{ $concern->victim_gender }}</span></td>
            </tr>
            <tr>
                <td>Grade & Section:
                    <span id="victim_grade" style="width: 215px;">{{ $concern->victim_grade }}</span>
                </td>
            </tr>
            <tr>
                <td>Parents/Guardian: <span id="victim_parent_guardian">{{ $concern->victim_parent_guardian }}</span></td>
                <td>Signature: <span
                        style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </td>
            </tr>
            <tr>
                <td>Contact no: <span id="victim_parent_contact"
                        style="width: 242px;">{{ $concern->victim_parent_contact }}</span>
                </td>
            </tr>
            <tr>
                <td>Class Adviser: <span id="victim_class_adviser"
                        style="width: 225px;">{{ $concern->victim_class_adviser }}</span>
                </td>
                <td>Signature: <span
                        style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </td>
            </tr>
        </table>
    </div>
    <div class="table-title">
        <h5><b>B. COMPLAINANT</b></h5>
    </div>
    <div class="table-container">
        <table class="w-100">
            <tr>
                <td>Name: <span id="complainant_name" style="width: 273px;">{{ $concern->student->firstname }}</span></td>
                <td>Signature: <span
                        style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </td>
            </tr>
            <tr>
                <td>Address: <span id="complainant_address"
                        style="width: 260px;">{{ $concern->student->fullAddress() }}</span>
                </td>
            </tr>
            <tr>
                <td>Contact no: <span id="complainant_contact"
                        style="width: 242px;">{{ $concern->student->contact_no }}</span></td>
            </tr>
            <tr>
                <td>Relation to the Victim: <span id="relation_to_victim"
                        style="width: 173px;">{{ $concern->relation_to_victim }}</span></td>
            </tr>
        </table>
    </div>
    <div class="table-title">
        <h5><b>C. OFFENDER/S</b></h5>
    </div>
    <div class="table-container">
        <table class="w-100">
            <tr>
                <td>Name: <span id="offender_name" style="width: 273px;">{{ $concern->offender_name }}</span></td>
                <td>Signature: <span
                        style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </td>
            </tr>
            <tr>
                <td>Age: <span id="offender_age" style="width: 285px;">{{ $concern->offender_age }}</span></td>
                <td>Gender: <span id="offender_gender" style="width: 215px;">{{ $concern->offender_gender }}</span>
                </td>
            </tr>
            <tr>
                <td>Grade & Section:
                    <span id="offender_grade" style="width: 215px;">{{ $concern->offender_grade }}
                    </span>
                </td>
            </tr>
            <tr>
                <td>Parents/Guardian: <span id="offender_parent_guardian">{{ $concern->offender_parent_guardian }}</span>
                </td>
                <td>Signature: <span
                        style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </td>
            </tr>
            <tr>
                <td>Contact no: <span id="offender_parent_contact"
                        style="width: 242px;">{{ $concern->offender_parent_contact }}</span></td>
            </tr>
            <tr>
                <td>Class Adviser: <span id="offender_class_adviser"
                        style="width: 225px;">{{ $concern->offender_class_adviser }}</span></td>
                <td>Signature: <span
                        style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </td>
            </tr>
        </table>
    </div>
    <div>
        <h5 class="title"><b>II. PROBLEM PRESENTED</b></h5>
        <div class="description">
            <p id="main_concern">{{ $concern->main_concern }}</p>
        </div>
        <h5 class="title"><b>Action Taken:</b></h5>
        <div class="description">
            <p id="action_taken">{{ $concern->action_taken }}</p>
        </div>
        <h5 class="title"><b>Recommendation:</b></h5>
        <div class="description">
            <p id="recommendation">{{ $concern->recommendation }}</p>
        </div>
    </div>
@endsection
