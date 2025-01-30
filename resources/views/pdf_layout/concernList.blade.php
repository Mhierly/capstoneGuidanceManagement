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
@endsection
