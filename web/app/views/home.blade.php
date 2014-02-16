@extends("layout.main")

@section("css")
	<style>
      #map-canvas {
        height: 100%;
		width: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
@stop

@section("js")
	
	{{$map}}
	
@stop

@section("content")
	<div class="row">
		<div class="col-xs-7">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h4>Reports</h4>
				</div>
				
				<div class="panel-body">
					
					<section class="filters clearfix">
						<ul class="list list-inline pull-left">
							<li><a href="#">Link 1</a></li>
							<li><a href="#">Link 1</a></li>
							<li><a href="#">Link 1</a></li>
						</ul>
						
						<ul class="list list-inline pull-right down" >
							<li>
								<div class="btn-group">
								  <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">
								    Action <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu" role="menu">
								    <li><a href="#">Link 1</a></li>
								    <li><a href="#">Another link</a></li>
								    <li><a href="#">Something else here</a></li>
								    <li class="divider"></li>
								    <li><a href="#">Separated link here :D</a></li>
								  </ul>
								</div>
							</li>
						</ul>
						
						
					</section>
					
					<section class="list-group reports">
						
						
							
						@foreach(Report::all() as $report)
							<a href="{{URL::route('report-details', array('id' => $report->id))}}" class="list-group-item">
								<article class="clearfix">

									
									<figure class="pull-left" style="margin-right: 30px">
										<img src="{{URL::route('home')}}{{$report->image->path}}" alt="Image" class="img-rounded" width="120" height="100"/>
									</figure>
									
									<div class="reports-body">
										
										<header>
											<h1>{{$report->report_Desc}}</h1>
										</header>
										
										<p class="list-group-item-text">
											{{$report->location->location}}
										</p>
										
									</div>
								</article>
							</a>
						@endforeach
					</section>
				</div>
			</div>
		</div>
		
		
		<div class="col-xs-5">
			<div id="map-canvas">
				
			</div>
		</div>
		
	</div>
@stop
