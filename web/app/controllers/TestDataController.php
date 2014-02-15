<?php

class TestDataController extends BaseController {

  public function getTestData()
  {
    return Response::json(array('hello' => 'world', 'nested' => array('this' => array('is', 'a', 'nested', 'array'))));
  }

}