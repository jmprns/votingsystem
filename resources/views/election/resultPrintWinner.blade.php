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

h1, h2, h3{
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

.right{
	text-align: right;
}

</style>
</head>
<body>
<h1 align="center">ELECTION WINNER RESULT</h1>
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

				@php($candidates = $position->candidates->sortByDesc('votes_count')->take($position->max))
                @php($x = 1)

                @foreach($candidates as $candidate)
                @php($cname = explode('__', $candidate->info->name))
                    <tr>
                        <td colspan="3"><strong>{{ $position->name }}</strong></td>
                        <td colspan="3">{{ $cname[0] }}, {{ $cname[1] }} {{ @$cname[2][0] }}.</td>
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
	    			@php($candidates = $candidates->where('info.course_id', $course['id'])->take($position->max))
                    


                    @foreach($candidates as $candidate)



	                    	
		                    @php($cname = explode('__', $candidate->info->name))
		                    <tr>
		                        <td colspan="3"><strong>{{ $position->name }}</strong> <br> ({{ $course['name'] }})</td>
		                        <td colspan="3">{{ $cname[0] }}, {{ $cname[1] }} {{ @$cname[2][0] }}</td>
		                        <td colspan="3">{{ $candidate->party->name }}</td>
		                        <td>{{ $voters_count }}</td>
		                        <td>{{ $candidate->votes_count }}</td>
		                        <td>{{ vote_percentage($candidate->votes_count, $voters_count) }}%</td>
		                    </tr>
			                


	                   

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
	    		@php($candidates = $candidates->where('info.year_id', $year['id'])->take($position->max))

                @foreach($candidates as $candidate)
                
                    @php($cname = explode('__', $candidate->info->name))
                    <tr>
                        <td colspan="3"><strong>{{ $position->name }}</strong> <br> ({{ $year['courseName'] }} - {{ $year['yearName'] }})</td>
                        <td colspan="3">{{ $cname[0] }}, {{ $cname[1] }} {{ @$cname[2][0] }}</td>
                        <td colspan="3">{{ $candidate->party->name }}</td>
                        <td>{{ $voters_count }}</td>
                        <td>{{ $candidate->votes_count }}</td>
                        <td>{{ vote_percentage($candidate->votes_count, $voters_count) }}%</td>
                    </tr>

                @endforeach
    		@endforeach
			@endif
		@endforeach
	</tbody>
</table>

<div class="right">
	<p><strong>Total Voters:</strong> {{ $voters->count() }}</p>
	<p><strong>Uncasted Votes:</strong> {{ $voters->where('cast', 0)->count() }}</p>
	<p><strong>Casted Votes:</strong> {{ $voters->where('cast', 1)->count() }}</p>
</div>

<h2>PROOFREAD BY:</h2>
<br><br>
@php($name = explode('__', Auth::user()->name))
<h3>{{ strtoupper($name[1]) }} {{ strtoupper($name[2][0]) }}. {{ strtoupper($name[0]) }}</h3>

<script>
	window.print();
</script>
</body>
</html>