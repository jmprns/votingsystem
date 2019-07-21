<h2>Information</h2>
<hr>
<div class="row">
	<div class="col-lg-6">
		<table class="table table-responsive table-bordered table-hover">
	
			<tr>
				<td><strong>System Name:</strong></td>
				<td>Online Voting System</td>
			</tr>

			<tr>
				<td><strong>Programming Language:</strong></td>
				<td>PHP - Laravel</td>
			</tr>

			<tr>
				<td><strong>PHP Version</strong></td>
				<td>{{ phpversion() }}</td>
			</tr>

			<tr>
				<td><strong>Browser Info:</strong></td>
				@php($browser = Agent::browser())
				<td>{{ $browser }} - {{ Agent::version($browser) }}</td>
			</tr>

			<tr>
				<td><strong>System Environment</strong></td>
				<td>@if(Agent::isDesktop() == 1) Desktop @else Mobile @endif</td>
			</tr>

			<tr>
				<td><strong>IP Address</strong></td>
				<td>{{ Request::ip() }}:8051</td>
			</tr>

			<tr>
				<td><strong>Users</strong></td>
				<td>{{ App\User::all()->count() }}</td>
			</tr>

		</table>
	</div>
</div>