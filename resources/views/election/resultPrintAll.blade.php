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
<h1 align="center">ELECTION OVERALL RESULT</h1>
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

				<?php
			        $courses = array();
			        foreach($position->candidates as $candidate){
			            if(!array_key_exists($candidate->info->course_id, $courses)){
			                $courses[$candidate->info->course_id] = array('id' => $candidate->info->course_id, 'name' => $candidate->info->course->name);
			            }
			        }
	    		?>

	    		@foreach($courses as $course)

	    			<?php
	    				$voters_count = 0;
	    				foreach($voters as $voter){
	    					if($voter->course_id == $course['id']){
	    						$voters_count++;
	    					}
	    				}
	    			?>

	    			@php($candidates = $position->candidates->sortByDesc('votes_count'))
                    @php($x = 1)
                    @foreach($candidates as $candidate)
                    @if($candidate->info->course_id == $course['id'])
	                    @php($cname = explode('__', $candidate->info->name))
	                    <tr>
	                        <td colspan="3"><strong>{{ $position->name }}</strong> <br> ({{ $course['name'] }})</td>
	                        <td colspan="3">{{ $cname[0] }}, {{ $cname[1] }} {{ @$cname[2][0] }}</td>
	                        <td colspan="3">{{ $candidate->party->name }}</td>
	                        <td>{{ $voters_count }}</td>
	                        <td>{{ $candidate->votes_count }}</td>
	                        <td>{{ vote_percentage($candidate->votes_count, $voters_count) }}%</td>
	                    </tr>
                    @endif
                    @endforeach

	    		@endforeach



			

			@else

			<?php 
		        $years = array();
		        foreach($position->candidates as $candidate){
		            if(!array_key_exists($candidate->info->year_id, $years)){
		                $years[$candidate->info->year_id] = array('id' => $candidate->info->year_id,'yearName' => $candidate->info->year->name, 'courseName' => $candidate->info->course->name);
		            }
		        }
    		?>

    		@foreach($years as $year)
    			<?php
    				$voters_count = 0;
    				foreach($voters as $voter){
    					if($voter->course_id == $year['id']){
    						$voters_count++;
    					}
    				}
	    		?>


	    		@php($candidates = $position->candidates->sortByDesc('votes_count'))
                @foreach($candidates as $candidate)
                    @if($candidate->info->year_id == $year['id'])
                        @php($cname = explode('__', $candidate->info->name))
                        <tr>
	                        <td colspan="3"><strong>{{ $position->name }}</strong> <br> ({{ $year['courseName'] }} - {{ $year['yearName'] }})</td>
	                        <td colspan="3">{{ $cname[0] }}, {{ $cname[1] }} {{ @$cname[2][0] }}</td>
	                        <td colspan="3">{{ $candidate->party->name }}</td>
	                        <td>{{ $voters_count }}</td>
	                        <td>{{ $candidate->votes_count }}</td>
	                        <td>{{ vote_percentage($candidate->votes_count, $voters_count) }}%</td>
	                    </tr>
                    @endif
                @endforeach
    		@endforeach
			@endif
		@endforeach
	</tbody>
</table>

<script>
	window.print();
</script>
</body>
</html>