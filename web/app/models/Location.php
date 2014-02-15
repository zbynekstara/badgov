<?php

class Location extends Eloquent {
	//string contains the name of table in the database
	protected $table = "locations";
	
	//array of fields which can be filled
	protected $fillable = array("locX", "locY", "location");
	
	
}
