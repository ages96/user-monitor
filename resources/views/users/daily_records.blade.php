@include('layouts.header')
<div class="container">
    <h1>Daily Records</h1>
    <table class="table" id="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Male Count</th>
                <th>Female Count</th>
                <th>Male Average Age</th>
                <th>Female Average Age</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dailyRecords as $record)
                <tr>
                    <td>{{ $record->date }}</td>
                    <td>{{ $record->male_count }}</td>
                    <td>{{ $record->female_count }}</td>
                    <td>{{ number_format($record->male_avg_age,2); }}</td>
                    <td>{{ number_format($record->female_avg_age,2); }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('layouts.footer')