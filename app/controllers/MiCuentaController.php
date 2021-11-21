<?php

class MiCuentaController extends BaseController {

	/**
	 * Show My Account
	 *
	 */
	protected function getIndex()
	{
		$user = Auth::user();
		$lotes = [];

		return View::make('site/partials/mi-cuenta/index',compact('user','lotes'));

	}

}
