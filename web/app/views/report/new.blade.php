@extends("layout.main")

@section("content")
	<form method="post" action="{{URL::route('report-submit-post')}}" enctype="multipart/form-data">
		<textarea name="report_Desc">Desction</textarea>
		<select name="report_type">
			<option value="1">corruption</option>
			<option value="2">Something Else</option>
		</select>
		<input type="text" name="loc_longitude" placeholder="Longitude"/>
		<input type="text" name="loc_latitude" placeholder="loc_latitude"/>loc_location
		<input type="text" name="loc_location" placeholder="loc_location"/>
		<input type="text" name="Date_Time" placeholder="Date Time"/>
		<input type="file" name="Photo" />
		<br />
		<input type="submit" value="Report" />
	</form>
@stop
