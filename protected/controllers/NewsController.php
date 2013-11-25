<?php

class NewsController extends Controller
{

	public $title = 'Новости';

    protected function beforeAction($event)
    {
		Yii::app()->setGlobalState('top_menu', '');
        return true;
    }

	public function actionIndex()
	{

		Yii::app()->setGlobalState('top_menu', 'news');

		$news = new News('search');

		$this->render('index', array(
			'news' => $news
		));
	}

	public function actionCreate()
	{
		Yii::app()->setGlobalState('top_menu', 'news');
				
		$id = 0;
		$model = new News;

		if (isset($_POST['News'])) {

			$model->title = $_POST['News']['title'];
			$model->news = $_POST['News']['news'];

			if ($model->save()) {

				$this->redirect(array('index'));
			}
		}


		$this->render('update', array(
			'model' => $model,
			'id' => $id
		));		
	}

	public function actionUpdate()
	{
		$id = $_GET['id'];

		$model = News::model()->findByPk($id);

		if (isset($_POST['News'])) {

			$model->title = $_POST['News']['title'];
			$model->news = $_POST['News']['news'];
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
		News::model()->deleteByPk($id);
	}

}