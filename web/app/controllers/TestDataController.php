<?php

class TestDataController extends BaseController {

  public function getTestData()
  {
    return Response::json(array('hello' => 'world', 'nested' => array('this' => array('is', 'a', 'nested', 'array'))));
  }

  public function getTwitterTest()
  {
    $settings = array(
      'oauth_access_token' => "2344979191-jftihe71X1Ls4uveYEiLpEFxTHidCJh1n3QhXl1",
      'oauth_access_token_secret' => "rWFgwYIJQS4cxvICKvcSEovMw3pqIyePuIwRIlZ493eaI",
      'consumer_key' => "aSvTZCvgSNfa6kkj41RHQ",
      'consumer_secret' => "JUBsyweHzviiVy6TirESrMgov9I0qeNYBQPLWf5mRQ"
    );

    $url = 'https://api.twitter.com/1.1/statuses/update.json';
    $requestMethod = 'POST';
    $postfields = array('status' => 'test post');
    
    $twitter = new TwitterAPIExchange($settings);

	echo $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();

    return Response::json(array('test' => 'twitter'));
  }

}