<?php

class CatalogsController extends Controller
{

	public $title = 'Каталог';

    protected function beforeAction($event)
    {
		Yii::app()->setGlobalState('top_menu', '');
        return true;
    }

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{

		Yii::app()->setGlobalState('top_menu', 'catalogs');

        $criteria = new CDbCriteria;

        $criteria->condition= 'is_delete=0';

        $catalogs = new CActiveDataProvider('Catalogs', array(
                        'criteria'   => $criteria,
                        'pagination' => false
                ));


		//$catalogs = new Catalogs('search');

		$this->render('index', array(
			'catalogs' => $catalogs,
		));
	}

	public function actionUpdate()
	{

		Yii::app()->setGlobalState('top_menu', 'catalogs');

		$id = ($_POST['id']?$_POST['id']:$_GET['id']);

		if ($id>0) {
			$catalog = Catalogs::model()->findByPk($id);
		} else {
			$catalog = new Catalogs;
		}

		if (isset($_POST['Catalogs'])) {

			$catalog->attributes = $_POST['Catalogs'];

			$catalog->from_date = date('Y-m-d', strtotime($_POST['Catalogs']['from_date']));

			$catalog->to_date = date('Y-m-d', strtotime($_POST['Catalogs']['to_date']));

			if (isset($_FILES['my_image'])) {

				$base_path = Yii::getPathOfAlias('webroot').'/themes/test/img/flash/';

				$target_path = $base_path . basename($_FILES['my_image']['name']);

				if(move_uploaded_file($_FILES['my_image']['tmp_name'], $target_path)) {

					$old_file = $base_path.$catalog->image;

					@unlink($old_file);

					$catalog->image = basename( $_FILES['my_image']['name']);

					chmod($target_path, 0777);


				}
			}


			$catalog->save();

			$this->redirect(Yii::app()->createUrl('catalogs'));
		}

		$this->render('edit', array(
			'catalog' => $catalog,
		));

	}

	public function actionDelete()
	{

		$id = $_GET['id'];

		$catalog = Catalogs::model()->findByPk($id);

		$catalog->is_delete = 1;

		$catalog->save();
	}

	public function actionHints()
	{

		Yii::app()->setGlobalState('top_menu', 'hints');

		$hints = new Hints('search');

		$this->render('hints', array(
			'hints' => $hints,
		));
	}

	public function actionCreateHints()
	{

		Yii::app()->setGlobalState('top_menu', 'hints');
		
		$id = ($_POST['id']?$_POST['id']:$_GET['id']);

		if ($id>0) {
			$hints = Hints::model()->findByPk($id);
		} else {
			$hints = new Hints;
		}

		if (isset($_POST['Hints'])) {

			$hints->attributes = $_POST['Hints'];

			$hints->save();

			if ($id>0) {

			} else {
				$id = Yii::app()->db->getLastInsertId();
			}

			$pos_catalogs = $_POST['catalog'];

			HintsFleshka::model()->deleteAll('id_hints='.$id);

			if (count($pos_catalogs)>0) {

				foreach($pos_catalogs as $id_catalog => $pos_catalog) {

					$hints_fleshka = new HintsFleshka;
					$hints_fleshka->id_hints = $id;
					$hints_fleshka->id_catalog = $id_catalog;
					$hints_fleshka->save();

				}
			}			

			$this->redirect(Yii::app()->createUrl('catalogs/hints'));
		}

		$catalogs = Catalogs::model()->findAll('is_delete=0');

		$this->render('editHints', array(
			'hints' => $hints,
			'catalogs' => $catalogs			
		));

	}

	public function actionDeleteHints()
	{
		$id = $_GET['id'];
		HintsFleshka::model()->deleteAll('id_hints='.$id);
		Hints::model()->deleteByPk($id);
	}

}