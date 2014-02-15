@extends("layout.main")

@section("content")
	<div class="row">
		<div class="col-xs-12">
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
						
						@for($i = 0; $i < 5; $i++)
							<a href="" class="list-group-item">
								<article class="clearfix">

									
									<figure class="pull-left" style="margin-right: 30px">
										<img src="http://3.bp.blogspot.com/-SAXKuaWddT8/T7oOJGBi8CI/AAAAAAAAAWc/qSL9GTnlpSM/s1600/BossLecturing.jpg" alt="Image" class="img-rounded" width="120" height="100"/>
									</figure>
									
									<div class="reports-body">
										
										<header>
											<h1>Report Header</h1>
										</header>
										
										<p class="list-group-item-text">
											Report Description
										</p>
										
									</div>
								</article>
							</a>
						@endfor
					</section>
				</div>
			</div>
		</div>
		
	</div>
@stop
