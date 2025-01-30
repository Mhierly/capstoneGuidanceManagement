@extends('pdf_layout.pdfLayout')
@section('page-content')
    <style>
        table,
        td,
        th {
            border: 1px solid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .certificate-footer {
            margin-top: 40px;
            text-align: left;
        }

        .certificate-footer .signature {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
        }

        .certificate-footer .signature strong {
            border-bottom: 2px solid black;
        }
    </style>
    <div class="title" style="align-content: center; text-align:center">
        <h2><b>DISCIPLINARY CASE STUDENT</b></h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>
                    DATE REPORTED
                </th>
                <th>NAME OF STUDENT</th>
                <th>YEAR LEVEL / SECTION</th>
                <th>CASE</th>
                <th>ACTION TAKEN</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($concernList as $item)
                <tr>
                    <td>{{ $item->created_at->format('F d,Y h:m') }}</td>
                    <td>{{ strtoupper($item->offender_name) }}</td>
                    <td>{{ $item->offender_grade . ' ' . $item->offender_section }}</td>
                    <td>{{ $item->main_concern }}</td>
                    <td>{{ $item->action_taken }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No Data</td>
                </tr>
            @endforelse
        </tbody>
    </table>


    <div class="certificate-footer">
        <p>Prepared by:</p>
        <div class="signature">
            <strong>ARLENE M. BALARIA</strong><br>
            <span>Guidance Councilor</span>
        </div>
    </div>
@endsection
