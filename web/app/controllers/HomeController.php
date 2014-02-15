<?php

class HomeController extends BaseController {


	public function getHomePage()
	{
		return View::make('home');
	}

}