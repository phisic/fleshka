<?php

class AdvertisingController extends Controller
{

	public $title = 'Реклама';

    protected function beforeAction($event)
    {
		Yii::app()->setGlobalState('top_menu', 'advertising');
        return true;
    }

	public function actionIndex()
	{

		$model = new Advertising('search');

		$this->render('index', array(
			'model' => $model
		));
	}

	public function actionUpdate()
	{

		//print_r($_POST);

		if (isset($_GET['id'])) {

			$id = $_GET['id'];

			$model = Advertising::model()->findByPk($id);

		} else {
			$model = new Advertising;
		}

		if (isset($_POST['Advertising'])) {

			if (isset($_POST['Advertising']['picture'])) {

				if ($_FILES['Advertising']['size']['picture']>0) {

					$base_path = Yii::getPathOfAlias('webroot').'/images/';

					$target_path = $base_path . basename($_FILES['Advertising']['name']['picture']);

					if(move_uploaded_file($_FILES['Advertising']['tmp_name']['picture'], $target_path)) {

						if (isset($_GET['id'])) {

							$old_file = $base_path.$model->picture;

							@unlink($old_file);
						}

						$model->picture = basename( $_FILES['Advertising']['name']['picture']);

						chmod($target_path, 0777);

					} else{
						$error = "There was an error uploading the file, please try again!";
						die('ddd');
					}
				}
			}

			$model->text_advertising = $_POST['Advertising']['text_advertising'];
			$model->url = $_POST['Advertising']['url'];
			$model->blank = $_POST['Advertising']['blank'];
			$model->is_active = $_POST['Advertising']['is_active'];
			$model->save();

			$this->redirect(array('index'));
		}


		$this->render('update', array(
			'model' => $model,
			'id' => $id
		));

	}

	public function actionDelete()
	{
		$id = $_GET['id'];
		Advertising::model()->deleteByPk($id);
	}

	public function actionShow()
	{

		$cache_key = 'top_reklama';

		$reklama = Yii::app()->cache->get($cache_key);

		if($reklama===false) {

			$advertising = Advertising::model()->findAll('is_active=1');

			$reklama = $this->renderPartial('only', array('advertising' => $advertising), true);

			Yii::app()->cache->set($cache_key, $reklama, 300);

		}	

		echo $reklama;
			
	}

}