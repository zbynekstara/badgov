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
		// $image_binary = fopen($_FILES["Photo"]["tmp_name"], "rb");
// 		
		// $mysqli = new mysqli("localhost", "user2635765", "shoftak", "db2635765-main");
// 		
		// $stmt = $mysqli->prepare("INSERT INTO reports(report_Desc, report_type, Date_Time, Photo, Location_id) VALUES (?, ?, ?, ?, ?)");
// 		
		// $stmt->bind_param('sisbi', $report_disc, $report_type, $date, $image_binary, 1);
// 		
		// $report_disc = Input::get("report_Desc");
		// $report_type = Input::get("report_type");
		// $date = Input::get("Date_Time");
// 		
		// $stmt->execute();
		
		$location = Location::create(array(
		    'locX' => Input::get("loc_longitude"),
		    "locY" => Input::get("loc_latitude"),
		    "location" => Input::get("loc_location"),
	    ));
		
		DB::table('reports')->insert(array(
		    'report_Desc' => Input::get("report_Desc"),
		    "report_type" => Input::get("report_type"),
		    "Date_Time" => Input::get("Date_Time"),
		    "Photo" => Input::file("Photo"),
		    "Location_id" => $location->id
	    ));
		
		$this->postToTwitter(URL::route("report-details", array(
				"id" => $report->id;
			)
		));
		
		
		
	}
	
	public function postToTwitter($url) {
		$settings = array(
			'oauth_access_token' => "2344979191-jftihe71X1Ls4uveYEiLpEFxTHidCJh1n3QhXl1",
      		'oauth_access_token_secret' => "rWFgwYIJQS4cxvICKvcSEovMw3pqIyePuIwRIlZ493eaI",
      		'consumer_key' => "aSvTZCvgSNfa6kkj41RHQ",
      		'consumer_secret' => "JUBsyweHzviiVy6TirESrMgov9I0qeNYBQPLWf5mRQ"
   		 );

    	$url = 'https://api.twitter.com/1.1/statuses/update.json';
    	$requestMethod = 'POST';
    	$postfields = array(
    		'status' => $this->tweet(Input::get("report_Desc"), $url)
    	);
    
    	$twitter = new TwitterAPIExchange($settings);

		echo $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();
             
        return Response::json(array('test' => 'twitter'));
	}
	
	public function tweet($input, $link) {
		$tweetText = $this->shorten($input);
		$tweetText .= " " . $link;
		return $tweetText;
	}
	
	public function shorten($originalString) {
		// length is 140-22-3-1-1 = 113
		$newString = substr($originalString, 0, 113);
		$newString .= "...";
		return $newString;
	}
}