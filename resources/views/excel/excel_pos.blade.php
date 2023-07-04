<table>
    <tr>
        <td colspan="4">Laporan POS
        </td>
    </tr>
</table>
<table>
    <thead>

        <tr>
            <th>No</th>
            <th>Full Name</th>
            <th>Title</th>
            <th>Company</th>
            <th>Email</th>
            <th>Industry</th>
            <th>Experience</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($pos as $key => $value)
            <tr>
                <th>{{ $no++ }}</th>
                <th>{{ $value->name }}</th>
                <th>{{ $value->title }}</th>
                <th>{{ $value->category }}</th>
                <th>{{ $value->email }}</th>
                <th>{{ $value->industry }}</th>
                <th>{{ $value->experience }}</th>
            </tr>
        @endforeach
    </tbody>
</table>
