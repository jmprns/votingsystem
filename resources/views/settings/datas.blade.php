<h2>Account Logs</h2>
<hr>
<table class="table table-responsive table-striped table-bordered table-hover data-account-table">
    <thead>
        <tr>

            <th>Timestamp</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logs['users'] as $user)
            @php($uName = @explode('__', $user->user->name))
            <tr>
                <td>{{ $user->created_at }}</td>
                <td>{{ $uName[0] }}, {{ $uName[1] }} {{ @$uName[2][0] }}.</td>
                <td>{{ $user->description }}</td>
            </tr>
        @endforeach
        @foreach($logs['voters'] as $voter)
            @php($vName = @explode('__', $voter->voter->name))
            <tr>
                <td>{{ $voter->created_at }}</td>
                <td>{{ $vName[0] }}, {{ $vName[1] }} {{ @$vName[2][0] }}.</td>
                <td>{{ $voter->description }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h2>Votes Logs</h2>
<hr>
<table class="table table-responsive table-striped table-bordered table-hover data-account-table">
    <thead>
        <tr>
            <th>Timestamp</th>
            <th>Name</th>
            <th>Candidate Voted</th>
            <th>Election</th>
        </tr>
    </thead>
    <tbody>
        @foreach($votes as $vote)
            @php($vName = @explode('__', $vote->voter->name))
            @php($cName = @explode('__', $vote->candidate->info->name))
            <tr>
                <td>{{ $vote->created_at }}</td>
                <td>{{ @$vName[0] }}, {{ @$vName[1] }} {{ @$vName[2][0] }}.</td>
                <td>{{ @$cName[0] }}, {{ @$cName[1] }} {{ @$cName[2][0] }}.</td>
                <td>{{ @$vote->candidate->election->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>