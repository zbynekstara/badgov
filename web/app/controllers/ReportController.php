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
		
		postToTwitter();
		
		
		
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
	
	public function postToTwitter() {
		$settings = array(
			'oauth_access_token' => "2344979191-jftihe71X1Ls4uveYEiLpEFxTHidCJh1n3QhXl1",
      		'oauth_access_token_secret' => "rWFgwYIJQS4cxvICKvcSEovMw3pqIyePuIwRIlZ493eaI",
      		'consumer_key' => "aSvTZCvgSNfa6kkj41RHQ",
      		'consumer_secret' => "JUBsyweHzviiVy6TirESrMgov9I0qeNYBQPLWf5mRQ"
   		 );

    	$url = 'https://api.twitter.com/1.1/statuses/update.json';
    	$requestMethod = 'POST';
    	$postfields = array(
    		'status' => tweet(
    			Input::get("report_Desc"),
    			"www.website.example"
    		)
    	);
    
    	$twitter = new TwitterAPIExchange($settings);

		echo $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();
	}
	
	public tweet(string $input, string $link) {
		$tweetText = shorten($input);
		$tweetText .= " " . $link
	}
	
	public shorten(string $originalString, int $newLength=114) {
		$newString = substring($originalString, 0, $newLength);
		$newString .= "...";
		return $newString;
	}
}