<?php

class HomeController extends BaseController {

	protected function mapsearch($Locations)
	{
  
	}

			
			
			
			
			
			
			
			
	public function getHomePage()
	{
		//$map = $this->mapsearch(Location::all());
		
		Session::put("locations", Location::all());
		var_dump(Session::get("locations"));
		return;
		
		
		return View::make('home', array(
			"map" => $map
		));
	}

}