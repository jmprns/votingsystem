<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

h1, h2{
	font-family: arial, sans-serif;
}

p{
	font-family: arial, sans-serif;
}

td, th {
  border: 1px solid #dddddd;
  text-align: center;
  padding: 8px;
}

</style>
</head>
<body>
<h1 align="center">ELECTION RESULT</h1>
<h2 align="center">{{ strtoupper($election->name) }}</h2>

<table>
	<thead>
		<tr>
		    <th colspan="3" rowspan="2">POSITION</th>
		    <th colspan="3" rowspan="2">NAME</th>
		    <th colspan="3" rowspan="2">PARTY</th>
		    <th colspan="3">VOTES</th>
  		</tr>
		<tr>
			<td>VOTERS</td>
			<td>ACCUMULATED</td>
			<td>PERCENTAGE</td>
		</tr>

	</thead>

	<tbody>
		@foreach($positions as $position)
			@if($position->type == 1)

				@php($candidates = $position->candidates->sortByDesc('votes_count'))
                @php($x = 1)

                @foreach($candidates as $candidate)
                @php($cname = explode('__', $candidate->info->name))
                    <tr>
                        <td colspan="3"><strong>{{ $position->name }}</strong></td>
                        <td colspan="3">{{ $cname[0] }}, {{ $cname[1] }} {{ @$cname[2][0] }}</td>
                        <td colspan="3">{{ $candidate->party->name }}</td>
                        <td>{{ $voters->count() }}</td>
                        <td>{{ $candidate->votes_count }}</td>
                        <td>{{ vote_percentage($candidate->votes_count, $voters->count()) }}%</td>
                    </tr>
                @endforeach

			@elseif($position->type ==2)

			@else
			@endif
		@endforeach
	</tbody>
</table>
</body>
</html>