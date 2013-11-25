<?php

class AdminController extends Controller
{

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$new_item = 1;
		
		$this->render('index', array(
			'new_items' => $new_items,
		));
	}

}