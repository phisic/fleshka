<?php

class AdminController extends Controller
{

	public $title = 'Админ';

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$new_item = 1;

		$this->render('index', array(
			'new_items' => $new_items,
		));
	}

	public function actionLogout()
	{

        Yii::app()->session['logoff'] = 1;

        unset(Yii::app()->session['user_id']);
        unset(Yii::app()->session['user']);

        $this->redirect(array('index'));
	}

	public function actionContacts()
	{

		Yii::app()->setGlobalState('top_menu', 'contacts');

		if (isset($_POST['Content']['content'])) {

			$model = Content::model()->find('name="contact"');

			$model->content = $_POST['Content']['content'];

			$model->save();
		}

		$this->title = 'Редактировать контакты';

		$model = Content::model()->find('name="contact"');

		$this->render('contacts', array(
			'model' => $model
		));
	}

	public function actionSelling_rules()
	{
		Yii::app()->setGlobalState('top_menu', 'selling_rules');

		if (isset($_POST['Content']['content'])) {

			$model = Content::model()->find('name="selling_rules"');

			$model->content = $_POST['Content']['content'];

			$model->save();
		}

		$this->title = 'Условия продажи';

		$model = Content::model()->find('name="selling_rules"');

		$this->render('contacts', array(
			'model' => $model
		));
	}

	public function actionDogovor()
	{

		Yii::app()->setGlobalState('top_menu', 'dogovor');

		$error = '';

		if (isset($_POST['upload_file'])) {

			$base_path = Yii::getPathOfAlias('webroot').'/dogovor/';

			$target_path = $base_path . basename( $_FILES['uploadedfile']['name']);

			if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {

				$content = Content::model()->find('name="dogovor"');

				$old_file = $base_path.$content->content;

				@unlink($old_file);

				$content->content = basename( $_FILES['uploadedfile']['name']);

				chmod($target_path, 0777);

				$content->save();

			} else{
				$error = "There was an error uploading the file, please try again!";
			}
		}

		$this->title = 'Стандартный договор';

		$content = Content::model()->find('name="dogovor"');

		$this->render('dogovor', array(
			'content' => $content,
			'error' => $error
		));
	}

	public function actionPresentation()
	{
		Yii::app()->setGlobalState('top_menu', 'presentation');

		$error = '';

		if (isset($_POST['upload_file'])) {

			$base_path = Yii::getPathOfAlias('webroot').'/dogovor/';

			$target_path = $base_path . basename( $_FILES['uploadedfile']['name']);

			if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {

				$content = Content::model()->find('name="presentation"');

				$old_file = $base_path.$content->content;

				@unlink($old_file);

				$content->content = basename( $_FILES['uploadedfile']['name']);

				chmod($target_path, 0777);

				$content->save();


			} else{
				$error = "There was an error uploading the file, please try again!";
			}
		}

		$this->title = 'Презентация';

		$content = Content::model()->find('name="presentation"');

		$this->render('presentation', array(
			'content' => $content,
			'error' => $error
		));
	}

	public function actionOrders()
	{

		Yii::app()->setGlobalState('top_menu', 'orders');

		$this->title = 'Заказы';

        $criteria = new CDbCriteria;

        $criteria->order = 'id desc';

        if (isset($_POST['search'])) {

        	$search = addslashes($_POST['search']);
	        $criteria->condition= 'email like "%'.$search.'%" or
	        				company like "%'.$search.'%" or
	        				phone like "%'.$search.'%" or
	        				address like "%'.$search.'%"';

        }

        $orders = new CActiveDataProvider('Morder', array(
                        'criteria'   => $criteria,
                        'pagination' => false
                ));

		$this->render('orders/index', array(
			'orders' => $orders
		));
	}

	public function actionDeleteOrder()
	{
		$id = $_GET['id'];
		$order = Morder::model()->find('id='.$id);

		if (count($order)>0) {
			$order_id = $order->order_id;

			$logos = Logos::model()->findAll('order_id="'.$order_id.'"');

			if (count($logos)>0) {
				$base_path = Yii::getPathOfAlias('webroot').'/logos/';
				foreach ($logos as $logo) {
				  @unlink($base_path.$logo->logo_name);
				}
			}

			Logos::model()->deleteAll('order_id="'.$order_id.'"');
			Ordercomments::model()->deleteAll('order_id="'.$order_id.'"');
			Morder::model()->deleteAll('id='.$id);
		}
	}

	public function actionUsers()
	{
		$this->title = 'Пользователи';
		$this->render('show_content', array(
			'content' => 'Under construction'
		));
	}

	public function actionContents()
	{
		$this->title = 'Контент';
		$this->render('show_content', array(
			'content' => 'Under construction'
		));
	}

	public function actionMeta_control()
	{
		Yii::app()->setGlobalState('top_menu', 'meta_control');

		$this->title = 'Мета контрол';

		$success = false;

		if (isset($_POST['Content']['content'])) {

			$keywords = Content::model()->find('name="keywords"');

			$keywords->content = $_POST['keywords'];

			$keywords->save();

			$description = Content::model()->find('name="description"');

			$description->content = $_POST['Content']['content'];

			$description->save();

			$success = true;

		}

		$keywords = Content::model()->find('name="keywords"');

		$description = Content::model()->find('name="description"');

		$this->render('meta_control', array(
			'keywords' => $keywords,
			'description' => $description,
			'success' => $success
		));

	}

	public function actionPhones()
	{

		Yii::app()->setGlobalState('top_menu', 'phones');

		$this->title = 'Телефоны';

		$success = false;

		if (isset($_POST['phone1'])) {

			$phone1 = Content::model()->find('name="phone1"');

			$phone1->content = $_POST['phone1'];

			$phone1->save();

			$phone2 = Content::model()->find('name="phone2"');

			$phone2->content = $_POST['phone2'];

			$phone2->save();

			$success = true;

		}


		$phone1 = Content::model()->find('name="phone1"');

		$phone2 = Content::model()->find('name="phone2"');

		$this->render('phones', array(
			'phone1' => $phone1,
			'phone2' => $phone2,
			'success' => $success
		));

	}
   	public function actionEmails()
	{

		Yii::app()->setGlobalState('top_menu', 'emails');

		$this->title = 'Список Email для обработки заказов';

		$success = false;

		$emaillist = Content::model()->exists('name="email_list"');

		if (!$emaillist) {
           $elist = new Content();
       	   $elist->name = 'email_list';

			$elist->content = '';
            $elist->created=time();
			$elist->save(false);

		}

			$sentemail = Content::model()->exists('name="email_sent"');

		if (!($sentemail)) {

			$sentemaila = new Content();

			$sentemaila->name = 'email_sent';

			$sentemaila->content = 0;
            $sentemaila->created=time();
			$sentemaila->save(false);

		}
		if (isset($_POST['emaillist'])) {

			$emaillistedit = Content::model()->find('name="email_list"');

			$emaillistedit->content = $_POST['emaillist'];

			$emaillistedit->save();


			$success = true;

		}

		$emaillist = Content::model()->find('name="email_list"');



		$this->render('emails', array(
			'emaillist' => $emaillist,
			'success' => $success
		));

	}

	public function actionEmail_template()
	{
		Yii::app()->setGlobalState('top_menu', 'email_template');

		$this->title = 'Email шаблоны';
		$this->render('show_content', array(
			'content' => 'Under construction'
		));
	}

}