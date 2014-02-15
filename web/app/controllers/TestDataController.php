<?php

class TestDataController extends BaseController {

  public function getTestData()
  {
    return Response::json(array('tweets' => array(
        array('profile' => 'https://abs.twimg.com/sticky/default_profile_images/default_profile_2_bigger.png',
          'tweet' => 'this is test data'),
        array('profile' => 'https://abs.twimg.com/sticky/default_profile_images/default_profile_2_bigger.png',
          'tweet' => 'this is more test data'),
        array('profile' => 'https://abs.twimg.com/sticky/default_profile_images/default_profile_2_bigger.png',
          'tweet' => 'woooooooo shoftak')
      ), 'count' => 1020));
  }

  public function getTwitterTest()
  {
    $this->postToTwitter();
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
    		'status' => $this->tweet("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.", "https://www.google.ae/?gws_rd=cr&ei=JJT_UpDzKZT20gWc14DYBw#q=nyuad")
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