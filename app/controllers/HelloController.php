<?php
/*
A Controller for testing stuff
*/

class HelloController extends BaseController
{
	public function showHello () 
	{
		return View::make('hello');
	}
}