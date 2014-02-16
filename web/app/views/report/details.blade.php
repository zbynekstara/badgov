@extends("layout.main")

@section("js")
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHCC9kEkn0BYIL8FTLAZ1UcAdnEtCl0_g&sensor=false">
    </script>
    
    <script type="text/javascript">
      function initialize() {
      	var location = new google.maps.LatLng({{$report->location->locY}}, {{$report->location->locX}}); 
        var mapOptions = {
          center: location,
          zoom: 12
        };
        var map = new google.maps.Map(document.getElementById("googleMap"),
            mapOptions);
            
        var marker = new google.maps.Marker({
		      position: location,
		      map: map,
		      title: 'Government @if($report->report_type == 1) Corruption @else Bad Service @endif at {{$report->location->location}}'
		  });
	      
	    
      }
      
      
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    
@stop

@section("content")
	<div class="row">
		<div class="col-xs-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<figure>
						<img src="{{URL::route('home')}}{{$report->image->path}}" alt="Image" height="400"/>
					</figure>
					
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<div id="googleMap" style="height: 400px;">
						
					</div>
					
				</div>
			</div>
			
		</div>
		
		<div class="col-xs-12">
			<p>
				<blockquote>
					{{$report->report_Desc}}
				</blockquote>
			</p>
		</div>
		
	</div>
@stop

