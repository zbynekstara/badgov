<?php

class Report extends Eloquent {
	//string contains the name of table in the database
	protected $table = "reports";
	
	//array of fields which can be filled
	protected $fillable = array("report_Desc", "report_type", "Date_Time", "fake_counter", "location_id");
	
	
}
