<?php

class ReportController extends BaseController {
	
	
	public function getNewReportPage() {
		
		return View::make("report.new");
		
	}
	
	public function getReport($report_id) {
		$report = Report::find($report_id);
		
		if ($report) {
			return View::make("report.details", array(
				"report" => $report
			));
		}
		
		return "This report doesn't exist";
	}
	
	public function postReportPhoto() {
		//$relative_path = "/uploads/" . $_FILES['file_image']['name'];
		
		
		
		$full_path = base_path() . "/public" . FileCustom::orderBy('id', 'desc')->first()->path;
		
		move_uploaded_file($_FILES['file_image']['tmp_name'], $full_path);
		
	}
	
	public function postReport()
	{
		
		$location = Location::create(array(
		    'locX' => Input::get("loc_longitude"),
		    "locY" => Input::get("loc_latitude"),
		    "location" => Input::get("loc_location"),
	    ));
		
		$file_path = "/uploads/" . str_random(3) . ".jpg";
		
		Session::put("file_path", $file_path);
		
		$report = Report::create(array(
		    'report_Desc' => Input::get("report_Desc"),
		    "report_type" => Input::get("report_type"),
		    "Date_Time" => Input::get("Date_Time"),
		    "location_id" => $location->id
	    ));
		
		
		
		$file = FileCustom::create(array(
			"path" => $file_path,
			"report_id" => $report->id
		));
		
		$text = urlencode(Input::get("report_Desc"));
		$url = urlencode(URL::route('report-details', array('id' => $report->id)));
		
		
		return Redirect::away("http://shoftakapp.eu1.frbit.net/submit?text=$text&url=$url");
		
		
		
		
	}
	
	public function postToTwitter($desription, $report_url) {
		$settings = array(
			'oauth_access_token' => "2344979191-jftihe71X1Ls4uveYEiLpEFxTHidCJh1n3QhXl1",
      		'oauth_access_token_secret' => "rWFgwYIJQS4cxvICKvcSEovMw3pqIyePuIwRIlZ493eaI",
      		'consumer_key' => "aSvTZCvgSNfa6kkj41RHQ",
      		'consumer_secret' => "JUBsyweHzviiVy6TirESrMgov9I0qeNYBQPLWf5mRQ"
   		 );

    	$url = 'https://api.twitter.com/1.1/statuses/update.json';
    	$requestMethod = 'POST';
    	$postfields = array(
    		'status' => $this->tweet($desription, $report_url)
    	);
    
    	$twitter = new TwitterAPIExchange($settings);

		return $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();
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