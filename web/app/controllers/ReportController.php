<?php

class ReportController extends BaseController {

	
	public function getNewReportPage() {
		
		return View::make("report.new");
		
	}
	
	public function showImage() {
		$report = DB::table("reports")->where("ID", "=", 5)->first();
		
		$image = $report->Photo;

		return View::make("report.image", array(
			"img" => base64_encode($image)
		));
	}
	
	
	
	public function postReport()
	{
		
		
		$relative_path = "/public/uploads/" . $_FILES['file_image']['name'];
		
		$full_path = base_path() . $relative_path;
		
		move_uploaded_file($_FILES['file_image']['tmp_name'], $full_path);
		
		
		$location = Location::create(array(
		    'locX' => Input::get("loc_longitude"),
		    "locY" => Input::get("loc_latitude"),
		    "location" => Input::get("loc_location"),
	    ));
		
		$report = Report::create(array(
		    'report_Desc' => Input::get("report_Desc"),
		    "report_type" => Input::get("report_type"),
		    "Date_Time" => Input::get("Date_Time"),
		    "location_id" => $location->id
	    ));
		
		
		
		
		
		$file = FileCustom::create(array(
			"size" => $_FILES['file_image']['size'],
			"real_name" =>  $_FILES['file_image']['name'],
			"uploaded_name" => $_FILES['file_image']['name'],
			"path" => $relative_path,
			"type" => "image",
			"report_id" => $report->id
		));
		
		return;
		
		$file = FileCustom::createFile(Input::file("file_image"), "image", array("report_id" => $report->id));
		
		$relative_path = "/public/uploads/" . $_FILES['file_image']['name'];
		
		$full_path = base_path() . "/public/uploads/" . $_FILES['file_image']['name'];
		
		
		
		
	}

}