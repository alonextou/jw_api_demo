<?php

class SessionController extends BaseController {

	public function setLanguage($id)
	{
		Session::put('language', $id);
		return Redirect::back();
	}

	public function setCatalog($id)
	{
		Session::put('catalog', $id);
		return Redirect::back();
	}

}
