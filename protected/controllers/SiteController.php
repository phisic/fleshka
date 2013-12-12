<?php

class SiteController extends Controller
{
	public $limitAjax = 10;

    protected function beforeAction($event)
    {
		Yii::app()->setGlobalState('top_menu', '');
        return true;
    }

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'

		// new flash
		// $criteria = new CDbCriteria;
		// $criteria->condition = 'trash=0';
		// $criteria->order = 'id DESC';
		// $criteria->limit = '8';
		// $new_items = Descriptionsize::model()->findAll($criteria);

		$new_items = Relgoodscatalog::model()->with('descriptionsize')->findAll(array('condition' => 'descriptionsize.trash=0 and instock=1 and catalog_id=1'));

		// popular flash
		$criteria = new CDbCriteria;
		$criteria->order = 'id_popular DESC';
		//$criteria->limit = '8';
		$popular_items = Popular::model()->findAll($criteria);

		Yii::app()->setGlobalState('catalog_id', 0);
		Yii::app()->setGlobalState('type', '');

		Yii::app()->session['type'] = 'in_stock';
		Yii::app()->session['catalog_id'] = 1;

		$this->render('index', array(
			'new_items' => $new_items,
			'popular_items' => $popular_items
		));
	}

	public function actionSingle_item()
	{
		$my_search = $_GET['id'];

		if (strpos($my_search, ' ')) {

			$words = explode(' ', $my_search);

		} else {
			$words[] = $my_search;
		}

		foreach ($words as $search) {

			if (is_numeric($search)) {

				$fleshkas[] = $search;

				$sql = 'select descriptionsize.id as my_id from descriptionsize
						where trash=0
						and name like "%#'.$search.'%"';

				$searches = Yii::app()->db->createCommand($sql)->query();

				if (count($searches)>0) {
					foreach ($searches as $search) {
						$fleshkas[] = $search['my_id'];
					}
				}


			} else {

				//$word = ucfirst(mb_strtolower($id, mb_detect_encoding($id)));
				//$word = ucfirst($id);
				$word = mb_convert_case($search, MB_CASE_TITLE, 'UTF-8');

				$sql = 'select descriptionsize.id as my_id from descriptionsize, `search`
					 	where descriptionsize.id=`search`.goods_id
						and trash=0
						and word like "%'.$word.'%"
						order by descriptionsize.id limit 30';

				echo $sql;die;

				$searches = Yii::app()->db->createCommand($sql)->query();

				if (count($searches)>0) {
					foreach ($searches as $search) {
						$fleshkas[] = $search['my_id'];
					}
				}

				$sql = 'select descriptionprice.id as my_id from descriptionprice, `search`
					 	where descriptionprice.id=`search`.goods_id
						and trash=0
						and word like "%'.$word.'%"
						order by descriptionprice.id limit 30';

						echo $sql;die;

				$searches = Yii::app()->db->createCommand($sql)->query();

				if (count($searches)>0) {
					foreach ($searches as $search) {
						$fleshkas[] = $search['my_id'];
					}
				}

			}


		}

		Yii::app()->session['searched_word'] = $my_search;

		$this->render('single_item', array(
			'fleshkas' => $fleshkas,
			'searched_word' => $my_search,
			'show_hints' => 0
		));
	}

	public function actionSingle_new_item()
	{
		$id = $_POST['id'];

		$this->renderPartial('single_item_new', array(
			'fleshka_id' => $id,
		));
	}

	public function actionAddcatalog()
	{
		$catalog = new Catalogs;
		$catalog->id = 1;
		$catalog->name='Специальные предложения';
		$catalog->url="";
		$catalog->index=1;
		$catalog->show=1;
		$catalog->count=0;
		$catalog->image='special.jpg';
		$catalog->description='';
		$catalog->save();
	}

	public function actionAll_item()
	{
		$id = $_GET['id'];
		$limit = 15;
		// type: all, in_stock, to_order
		$type = $_GET['type'];

		Yii::app()->session['catalog_id'] = $id;
		Yii::app()->session['type'] = $type;

		// if catalog is special redirect it to home page
		// if ($id==1) {
		// 	$this->redirect(Yii::app()->request->baseUrl);
		// }

		switch ($type) {

			// na sklade
			case 'in_stock':
				// get all fleshkas
				$relgoodscatalogs = Relgoodscatalog::model()->with('descriptionsize')
						->findAll(array('condition' => 'descriptionsize.trash=0 and instock=1 and catalog_id=:id',
							'params' => array(':id' => $id),
							'order' => 'descriptionsize.index ASC',
							'limit' => $limit));

				// get all upakovkas

				$relgoodscatalog_upakovkas = Relgoodscatalog::model()->with('descriptionprice')
						->findAll(array('condition' => 'descriptionprice.trash=0 and instock=1 and catalog_id=:id',
							'params' => array(':id' => $id),
							'order' => 'descriptionprice.index ASC'));

				break;

			// na zakaz
			case 'to_order':

				// get all fleshkas
				$relgoodscatalogs = Relgoodscatalog::model()->with('descriptionsize')
						->findAll(array('condition' => 'descriptionsize.trash=0 and instock=0 and catalog_id=:id',
							'params' => array(':id' => $id),
							'order' => 'descriptionsize.index ASC',
							'limit' => $limit));

				// get all upakovkas
				$relgoodscatalog_upakovkas = Relgoodscatalog::model()->with('descriptionprice')
						->findAll(array('condition' => 'descriptionprice.trash=0 and instock=0 and catalog_id=:id',
							'params' => array(':id' => $id),
							'order' => 'descriptionprice.index ASC'));

				break;

			default:
				$relgoodscatalogs = Relgoodscatalog::model()->with('descriptionsize')
						->findAll(array('condition' => 'descriptionsize.trash=0 and catalog_id=:id',
							'params' => array(':id' => $id),
							'order' => 'descriptionsize.index ASC',
							'limit' => $limit));
				// get all upakovkas
				$relgoodscatalog_upakovkas = Relgoodscatalog::model()->with('descriptionprice')
						->findAll(array('condition' => 'descriptionprice.trash=0 and catalog_id=:id',
							'params' => array(':id' => $id),
							'order' => 'descriptionprice.index ASC'));

				break;

		}

		$catalog = Catalogs::model()->findByPk($id);

		$color_id = 0;

		$this->render('all_item', array(
			'relgoodscatalogs' => $relgoodscatalogs,
			'relgoodscatalog_upakovkas' => $relgoodscatalog_upakovkas,
			'catalog' => $catalog,
			'my_type' => $type,
			'color_id' => $color_id,
			'limit' => $limit,
			'limitAjax' => $this->limitAjax,
		));
	}

	public function actionAll_filter_item()
	{
		$id = $_GET['id'];

		// type: all, in_stock, to_order
		$type = $_GET['type'];

		$color_id = $_GET['color_id'];

		switch ($type) {

			case 'in_stock':

				$sql = 'select relgoodscatalog.id as my_id from relgoodscatalog, descriptionsize, colorprice
					 	where relgoodscatalog.goods_id=descriptionsize.id
						and colorprice.ident=descriptionsize.id
						and catalog_id='.$id.' and trash=0 and instock=1 and color_id='.$color_id.'
						group by relgoodscatalog.id
						order by descriptionsize.id limit 10';

				$items = Yii::app()->db->createCommand($sql)->query();

				foreach ($items as $item) {
					$relgoodscatalogs[] = Relgoodscatalog::model()->findByPk($item['my_id']);
				}
				break;

			case 'to_order':

				$sql = 'select relgoodscatalog.id as my_id from relgoodscatalog, descriptionsize, colorprice
					 	where relgoodscatalog.goods_id=descriptionsize.id
						and colorprice.ident=descriptionsize.id
						and catalog_id='.$id.' and trash=0 and instock=0 and color_id='.$color_id.'
						group by relgoodscatalog.id
						order by descriptionsize.id limit 10';

				$items = Yii::app()->db->createCommand($sql)->query();

				foreach ($items as $item) {
					$relgoodscatalogs[] = Relgoodscatalog::model()->findByPk($item['my_id']);
				}
				break;

			default:

				$sql = 'select relgoodscatalog.id as my_id from relgoodscatalog, descriptionsize, colorprice
					 	where relgoodscatalog.goods_id=descriptionsize.id
						and colorprice.ident=descriptionsize.id
						and catalog_id='.$id.' and trash=0 and color_id='.$color_id.'
						group by relgoodscatalog.id
						order by descriptionsize.id limit 10';

				$items = Yii::app()->db->createCommand($sql)->query();

				foreach ($items as $item) {
					$relgoodscatalogs[] = Relgoodscatalog::model()->findByPk($item['my_id']);
				}
				break;
		}

		$catalog = Catalogs::model()->findByPk($id);

		$this->render('all_item', array(
			'relgoodscatalogs' => $relgoodscatalogs,
			'catalog' => $catalog,
			'my_type' => $type,
			'color_id' => $color_id
		));
	}

	public function actionAjax_show_items()
	{
		$flesh_id = $_POST['id'];

		$color_id = $_POST['color_id'];
		$limit = $_POST['limit'];
		$where_color = '';
		if ($color_id>0) {
			$where_color = ' and color_id='.$color_id;
		}

		$id = Yii::app()->session['catalog_id'];

		// type: all, in_stock, to_order
		$type = Yii::app()->session['type'];

		switch ($type) {

			case 'in_stock':
				/*$sql = 'select relgoodscatalog.id as my_id from relgoodscatalog, descriptionsize, colorprice
					 	where relgoodscatalog.goods_id=descriptionsize.id
						and colorprice.ident=descriptionsize.id
						and catalog_id='.$id.' and trash=0 and instock=1'.$where_color.
						' group by relgoodscatalog.id
						order by descriptionsize.id ASC limit '.$limit.', '.$this->limitAjax;*/
				$sql ='SELECT `t`.`id` AS `my_id` FROM `relgoodscatalog` `t`  LEFT OUTER JOIN `descriptionsize` `descriptionsize` ON (`t`.`goods_id`=`descriptionsize`.`id`)
						WHERE (descriptionsize.trash=0 and instock=1 and catalog_id='.$id.')
						ORDER BY descriptionsize.index ASC
						LIMIT '.$limit.', '.$this->limitAjax;

				$items = Yii::app()->db->createCommand($sql)->query();

				foreach ($items as $item) {
					$relgoodscatalogs[] = Relgoodscatalog::model()->findByPk($item['my_id']);
				}

				break;

			case 'to_order':

				/*$sql = 'select relgoodscatalog.id as my_id from relgoodscatalog, descriptionsize, colorprice
					 	where relgoodscatalog.goods_id=descriptionsize.id
						and colorprice.ident=descriptionsize.id
						and descriptionsize.id > '.$flesh_id.
						' and catalog_id='.$id.' and trash=0 and instock=0'.$where_color.
						' group by relgoodscatalog.id
						order by descriptionsize.id ASC limit 10';*/
				$sql ='SELECT `t`.`id` AS `my_id` FROM `relgoodscatalog` `t`  LEFT OUTER JOIN `descriptionsize` `descriptionsize` ON (`t`.`goods_id`=`descriptionsize`.`id`)
						WHERE (descriptionsize.trash=0 and instock=0 and catalog_id='.$id.')
						ORDER BY descriptionsize.index ASC
						LIMIT '.$limit.', '.$this->limitAjax;

				$items = Yii::app()->db->createCommand($sql)->query();

				foreach ($items as $item) {
					$relgoodscatalogs[] = Relgoodscatalog::model()->findByPk($item['my_id']);
				}

				break;

			default:

				/*$sql = 'select relgoodscatalog.id as my_id from relgoodscatalog, descriptionsize, colorprice
					 	where relgoodscatalog.goods_id=descriptionsize.id
						and colorprice.ident=descriptionsize.id
						and descriptionsize.id > '.$flesh_id.
						' and catalog_id='.$id.' and trash=0'.$where_color.
						' group by relgoodscatalog.id
						order by descriptionsize.id ASC limit 10';*/
				$sql ='SELECT `t`.`id` AS `my_id` FROM `relgoodscatalog` `t`  LEFT OUTER JOIN `descriptionsize` `descriptionsize` ON (`t`.`goods_id`=`descriptionsize`.`id`)
						WHERE (descriptionsize.trash=0 and catalog_id='.$id.')
						ORDER BY descriptionsize.index ASC
						LIMIT '.$limit.', '.$this->limitAjax;

				$items = Yii::app()->db->createCommand($sql)->query();

				foreach ($items as $item) {
					$relgoodscatalogs[] = Relgoodscatalog::model()->findByPk($item['my_id']);
				}

				break;
		}

		if (count($relgoodscatalogs)==0) {

			echo 0;

		} else {

			$this->renderPartial('pages/all_item_show', array('relgoodscatalogs' => $relgoodscatalogs, 'color_id' => $color_id, 'limit_ajax' => $this->limitAjax));

		}

	}

	public function actionShow_all_image()
	{
		$fleshka_id = $_POST['fleshka_id'];
		$colorprice = $_POST['colorprice'];
		$width_picture = $_POST['width_picture'];
		$height_picture = $_POST['height_picture'];
		$show_thumb = $_POST['show_thumb'];

		$fleshka = Descriptionsize::model()->findByPk($fleshka_id);

		if (count($fleshka)==0) {
			$fleshka = Descriptionprice::model()->findByPk($fleshka_id);
		}

		$this->renderPartial('pages/single_item_photo', array(
			'fleshka' => $fleshka,
			'my_colorprice' => $colorprice,
			'width' => $width_picture,
			'height' => $height_picture,
			'show_thumb' => $show_thumb
		));

	}

	public function actionKorzina_add_color()
	{
		$colorprice_id = $_POST['colorprice_id'];
		$add = $_POST['add'];
		$order_id = $_POST['order_id'];

		if ($add==1) {

			$old_colors = Yii::app()->session['korzina_color'];
			$old_colors[$colorprice_id] = 1;
			Yii::app()->session['korzina_color'] = $old_colors;
		} else {
			$old_colors = Yii::app()->session['korzina_color'];
			unset($old_colors[$colorprice_id]);
			Yii::app()->session['korzina_color'] = $old_colors;
		}

		$this->save_size_colors($order_id);
	}

	public function actionKorzina_add_volume()
	{
		$volume = $_POST['volume'];
		$add = $_POST['add'];
		$order_id = $_POST['order_id'];

		if ($add==1) {

			$old = Yii::app()->session['korzina_volume'];
			$old[$volume] = 1;
			Yii::app()->session['korzina_volume'] = $old;
		} else {
			$old = Yii::app()->session['korzina_volume'];
			unset($old[$volume]);
			Yii::app()->session['korzina_volume'] = $old;
		}

		$this->save_size_colors($order_id);
	}

	public function actionKorzina_delete_fleshka()
	{
		$fleshka_id = $_POST['fleshka_id'];
		$order_id = $_POST['order_id'];

		// remove deleted item from session
		$old = Yii::app()->session['korzina_fleshkas'];
		unset($old[$fleshka_id]);
		Yii::app()->session['korzina_fleshkas'] = $old;

		// if order exists, remove it from database also
		$this->save_size_colors($order_id);

	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contacts page
	 */
	public function actionContacts()
	{
		Yii::app()->setGlobalState('top_menu', 'contact');

		$contact = Content::model()->find('name="contact"');

		$this->render('show_content',array(
			'title' => 'Контакты',
			'content' => $contact->content,
			'contact_page' => 1
		));
	}

	/**
	 * Displays the selling rules
	 */
	public function actionSelling_rules()
	{

		Yii::app()->setGlobalState('top_menu', 'selling');

		$contact = Content::model()->find('name="selling_rules"');

		$this->render('show_content',array(
			'title' => 'Условия продажи',
			'content' => $contact->content
		));
	}

	/**
	 * Download dogovor
	 */
	public function actionDogovor()
	{
		$dogovor = Content::model()->find('name="dogovor"');

		$webroot = Yii::getPathOfAlias('webroot');
		MyClass::file_download($webroot . '/dogovor/' . $dogovor->content, $dogovor->content);
	}

	/**
	 * Download presentation
	 */
	public function actionPresentation()
	{
		$presentation = Content::model()->find('name="presentation"');

		$webroot = Yii::getPathOfAlias('webroot');
		MyClass::file_download($webroot . '/dogovor/' . $presentation->content, $presentation->content);
	}


	/**
	 * Displays the news page
	 */
	public function actionNews()
	{

		Yii::app()->setGlobalState('top_menu', 'stati');

		$news = News::model()->findAll(array('order' => 'date_created desc'));

		$content = $this->renderPartial('show_news', array('news' => $news), true);

		$this->render('show_content',array(
			'title' => 'Статьи',
			'content' => $content,
		));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionColor()
	{
		// Content type
		header('Content-type: image/png');

		$colors = unserialize($_GET['color']);

		$width = 30;
		$height = 20;

		$im = imagecreatetruecolor($width, $height);

		$count_of_colors = count($colors);
		$width_begin = 0;
		$width_step = $width/$count_of_colors;
		for($i = 0; $i <= $count_of_colors; $i++) {

			$color_m[$i] = str_replace('#', '0x00', $colors[$i]);
			$rgb = $this->HexToRGB($colors[$i]);

			// Draw a white rectangle
			imagefilledrectangle($im,
								$width_begin,
								0,
								($width_begin+$width_step),
								30,
								imagecolorallocate($im, $rgb['r'], $rgb['g'], $rgb['b']));

			$width_begin += $width_step;
		}

		// Output
		imagepng($im);
		imagedestroy($im);
	}

	function HexToRGB($hex) {
		$hex = ereg_replace("#", "", $hex);
		$color = array();

		if(strlen($hex) == 3) {
			$color['r'] = hexdec(substr($hex, 0, 1) . $r);
			$color['g'] = hexdec(substr($hex, 1, 1) . $g);
			$color['b'] = hexdec(substr($hex, 2, 1) . $b);
		}
		else if(strlen($hex) == 6) {
			$color['r'] = hexdec(substr($hex, 0, 2));
			$color['g'] = hexdec(substr($hex, 2, 2));
			$color['b'] = hexdec(substr($hex, 4, 2));
		}

		return $color;
	}

	public function actionUploadLogo()
	{
		if (isset($_POST['upload_file'])) {

			$base_path = Yii::getPathOfAlias('webroot').'/logos/';

			// get file part info
			$path_parts = pathinfo($_FILES['uploadedfile']['name']);

			// get extension of uploaded file
			$extension = $path_parts['extension'];

			$filename = time().'.'.$extension;

			$target_path = $base_path . $filename;

			if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {

				chmod($target_path, 0777);

				//$filename = $_FILES['uploadedfile']['name'];

				$old = Yii::app()->session['korzina_logos'];
				$old[] = $filename;
				Yii::app()->session['korzina_logos'] = $old;

			} else{
				$error = "There was an error uploading the file, please try again!";
			}
		}

		$this->redirect(array('site/korzinka'));

	}

	public function actionSave_orders()
	{
		//print_r($_POST);die;
		// validations
		// ***************

		// check if empty email field
		$error = array();
		if (isset($_POST['email'])) {

			$validate = filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL );

			if ($validate===false) {

				if (trim($_POST['email'])=='') {

					$error['email'] = '"email" обязательное поле';

				} else {

					$error['email'] = 'введите верный "email"';
				}

				$error['email_value'] = $_POST['email'];
				$error['comment_value'] = $_POST['comment'];

			}

		}

		// check if company empty
		if (isset($_POST['company']) && trim($_POST['company'])=='') {

			$error['company'] = '"Название" обязательное поле';
		}

		// check if phone empty
		if (isset($_POST['phone']) && trim($_POST['phone'])=='') {

			$error['phone'] = '"Телефон" обязательное поле';
		}

		// check if address empty
		if (isset($_POST['address']) && trim($_POST['address'])=='') {

			$error['address'] = '"Адрес" обязательное поле';
		}

		//
		if (count($error)>0) {

			Yii::app()->setGlobalState('error', $error);

			$this->redirect(array('site/korzinka'));
		}

		$order_id = 0;
		if (isset($_POST['order_id'])) {
			$order_id = $_POST['order_id'];
			//Yii::app()->session['order_id'] = $order_id;
		}

		// create new order
		if ($order_id=='0') {
			$order = new Morder;
		} else {
			$order = Morder::model()->find('order_id="'.$order_id.'"');
		}

		if ($order_id=='0') {

			// unique order id
			$order_id = preg_replace('~[/+=]~','',base64_encode(pack('H*', md5(time()))));
			$order->order_id = $order_id;

			$order->date_created = date('Y-m-d h:i:s');

			if (isset($_POST['id_ot_text']) && $_POST['id_ot_text']!='') {

				$date_expire = date('Y-m-d', strtotime($_POST['id_ot_text']));
				$order->date_expire = $date_expire;
			}

			if (isset($_POST['id_do_text']) && $_POST['id_do_text']!='') {

				$date_expire_to = date('Y-m-d', strtotime($_POST['id_do_text']));
				$order->date_expire_to = $date_expire_to;
			}

			if (isset($_POST['delivery'])) {
				$order->delivery = $_POST['delivery'];
			}
			if (isset($_POST['email'])) {
				$order->email = $_POST['email'];
			}

			// must define what is it
			$order->state = 1;

			$order->group = 0;

		}

		if ($_POST['company']) {
			$order->company = $_POST['company'];
			$order->phone = $_POST['phone'];
			$order->address = $_POST['address'];
		}

		if ($order->save()) {

			// save color and sizes
			$this->save_size_colors($order_id);

			if ($_POST['comment']!='') {

				$ordercomments = new Ordercomments;
				$ordercomments->order_id = $order_id;
				$ordercomments->date_created = date('Y-m-d h:i:s');
				$ordercomments->manager_id = (isset(Yii::app()->session['user_id'])?Yii::app()->session['user_id']:0);
				$ordercomments->comment = $_POST['comment'];
				$ordercomments->save();
			}

			$this->send_email($order_id);

			$logo_files = Yii::app()->session['korzina_logos'];
			if (count($logo_files)>0) {

				foreach ($logo_files as $file) {

					$logos = new Logos;
					$logos->order_id = $order_id;
					$logos->logo_name = $file;
					$logos->save();
				}

			}

		}

		$this->redirect(array('site/korzinka', 'order_id' => $order_id));

	}

	function save_size_colors($order_id)
	{
		$order_id = addslashes($order_id);
		$order = Morder::model()->find('order_id="'.$order_id.'"');

		if (count($order)>0) {

			//set fleshkas, remove trash size and volume
			$sizes = Yii::app()->session['korzina_volume'];

			$fleshkas = Yii::app()->session['korzina_fleshkas'];

			$colors = Yii::app()->session['korzina_color'];

			// remove trash sizes

			if (count($sizes)>0) {

				foreach($sizes as $key => $size) {

					$bor = false;
					foreach($fleshkas as $fleshka => $tt) {

						if (strpos($key, $fleshka.'_')==false) {

							$bor = true;
						}
					}

					if ($bor==false) {
						unset($sizes[$key]);
					}

				}

				Yii::app()->session['korzina_volume'] = $sizes;

			}

			// remove trash colors
			if (count($colors)>0) {

				foreach($colors as $key => $color) {

					$colorprice = Colorprice::model()->findByPk($key);

					$bor = false;

					foreach($fleshkas as $fleshka => $tt) {

						if ($fleshka==$colorprice->ident) {
							$bor = true;
						}
					}

					if ($bor==false) {
						unset($colors[$key]);
					}
				}

				Yii::app()->session['korzina_color'] = $colors;
			}

			// set size
			$order_sizes = '';
			if (count($sizes)>0) {

				foreach($sizes as $key => $size) {

					$kk = str_replace("_", "-", $key);

					if ($order_sizes=='') {

						$order_sizes = $kk;

					} else {

						$order_sizes .= '_'.$kk;
					}
				}
			}

			$order->sizes = $order_sizes;

			// set color
			$order_colors = '';
			if (count($colors)>0) {
				foreach($colors as $key => $color) {

					if ($order_colors=='') {

						$order_colors = $key;

					} else {

						$order_colors .= '_'.$key;
					}
				}
			}

			$order->colors = $order_colors;

			$order->save();
		}

	}

	function get_size_colors($order_id)
	{
		$order_id = addslashes($order_id);
		$order = Morder::model()->find('order_id="'.$order_id.'"');

		if (count($order)>0) {

			unset(Yii::app()->session['korzina_fleshkas']);
			unset(Yii::app()->session['korzina_volume']);
			unset(Yii::app()->session['korzina_color']);

			// get sizes to session

			$sizes = $order->sizes;

			$array_sizes = array();

			$array_fleshkas = array();

			if ($sizes!='') {

				$ks = explode('_', $sizes);

				if (count($ks)>0) {

					foreach($ks as $k) {

						$m = str_replace('-', '_', $k);

						$array_sizes[$m] = 1;

						// get fleshkas
						$fl = explode('-', $k);
						$array_fleshkas[$fl[0]] = 1;

					}

					Yii::app()->session['korzina_volume'] = $array_sizes;

				}

			}

			// get colors to session

			$colors = $order->colors;

			$array_colors = array();

			if ($colors!='') {

				$ks = explode('_', $colors);

				if (count($ks)>0) {

					foreach($ks as $k) {

						// get size
						$array_colors[$k] = 1;

						// get fleshkas
						$colorprice = Colorprice::model()->findByPk($k);
						$array_fleshkas[$colorprice->ident] = 1;
					}

					Yii::app()->session['korzina_color'] = $array_colors;

				}

			}

			if (count($array_fleshkas)>0) {
				Yii::app()->session['korzina_fleshkas'] = $array_fleshkas;
			}

		}

	}

	public function actionReply_comment()
	{
		$order_id = $_POST['order_id'];

		$manager_id = $_POST['manager_id'];

		$ordercomments = new Ordercomments;
		$ordercomments->order_id = $order_id;
		$ordercomments->date_created = date('Y-m-d h:i:s');
		$ordercomments->manager_id = $manager_id;
		$ordercomments->comment = $_POST['comment'];
		$ordercomments->save();

		$this->send_email($order_id, $manager_id);

		$this->redirect(array('site/korzinka', 'order_id' => $order_id));
	}

	public function actionNew_korzinka() {

		unset(Yii::app()->session['order_id']);
		unset(Yii::app()->session['korzina_fleshkas']);
		unset(Yii::app()->session['korzina_color']);
		unset(Yii::app()->session['korzina_volume']);
		unset(Yii::app()->session['korzina_logos']);

		$this->redirect(array('site/korzinka'));
	}

	public function actionKorzinka() {

		// $all_fleshkas = Descriptionsize::model()->findAll();

		// foreach($all_fleshkas as $my_fleshka) {
		// 	if ($my_fleshka->pricesize2>1) {
		// 		$my_fleshka->pricesize2 = $my_fleshka->pricesize2 - 15;
		// 	}

		// 	if ($my_fleshka->pricesize4>1) {
		// 		$my_fleshka->pricesize4 = $my_fleshka->pricesize4 - 15;
		// 	}

		// 	if ($my_fleshka->pricesize8>1) {
		// 		$my_fleshka->pricesize8 = $my_fleshka->pricesize8 - 15;
		// 	}

		// 	if ($my_fleshka->pricesize16>1) {
		// 		$my_fleshka->pricesize16 = $my_fleshka->pricesize16 - 15;
		// 	}

		// 	if ($my_fleshka->pricesize32>1) {
		// 		$my_fleshka->pricesize32 = $my_fleshka->pricesize32 - 15;
		// 	}

		// 	$my_fleshka->save();

		// }

		// $email = EmailTemplate::model()->findByPk(17);
		// $email->content = 'На fleshka.ru для вас был создан запрос {NUMBER} .Нажмите эту <a href="{LINK}">ссылку</a>, чтобы просмотреть его';
		// $email->save();
		// echo 'fleshkas';
		// print_r(Yii::app()->session['korzina_fleshkas']);
		// echo 'colors';
		// print_r(Yii::app()->session['korzina_color']);
		// echo 'volumes';
		// print_r(Yii::app()->session['korzina_volume']);
		// echo 'logos';
		// print_r(Yii::app()->session['korzina_logos']);

		// unset(Yii::app()->session['korzina_fleshkas']);
		// unset(Yii::app()->session['korzina_color']);
		// unset(Yii::app()->session['korzina_volume']);
		// unset(Yii::app()->session['korzina_logos']);

		// echo 'korzina_fleshkas<br>';
		// print_r(Yii::app()->session['korzina_fleshkas']);
		// echo '<br>korzina_color<br>';
		// print_r(Yii::app()->session['korzina_color']);
		// echo '<br>korzina_volume<br>';
		// print_r(Yii::app()->session['korzina_volume']);
		// echo '<br>korzina_logos<br>';
		// print_r(Yii::app()->session['korzina_logos']);
		// die('kk');
         Yii::app()->setGlobalState('top_menu', 'korzinka');
		$order_id = 0;

		if (isset($_GET['order_id'])) {

			$order_id = $_GET['order_id'];
			Yii::app()->session['order_id'] = $order_id;

		} elseif (isset(Yii::app()->session['order_id'])) {

			$order_id = Yii::app()->session['order_id'];
		}


		$order_id = addslashes($order_id);

		// get error messages if exist
		$error = Yii::app()->getGlobalState('error');
		Yii::app()->setGlobalState('error', '');

		// get size and colors to session
		$this->get_size_colors($order_id);

		if (isset($_POST['colors'])) {

			// Array ( [colors] => 33,332,189,324,2434 [volumes] => 381_4,381_8,381_16,382_4,382_8 )
			$new_colors = $_POST['colors'];
			$new_volumes = $_POST['volumes'];

			$fleshkas = array();

			if (isset($_POST['flesh_id'])) {
				$fleshkas[$_POST['flesh_id']] = 1;
			}

			if ($new_colors!='' && $new_volumes!='') {

				$ms = explode(',', $colors);
				$colors = array();
				foreach($ms as $m) {
					$colors[$m] = 1;
				}

				$vs = explode(',', $new_volumes);
				$volumes = array();
				foreach($vs as $v) {
					$volumes[$v] = 1;
				}

				$colorprices = Colorprice::model()->findAll('id in ('.$new_colors.')');

				foreach ($colorprices as $colorprice) {

					$fleshkas[$colorprice->ident] = 1;
				}

			}

			// add new flashs to session
			$old_fleshkas = Yii::app()->session['korzina_fleshkas'];
			foreach($fleshkas as $key => $value) {
				$old_fleshkas[$key] = 1;
			}
			Yii::app()->session['korzina_fleshkas'] = $old_fleshkas;

			// add new colors to session
			$new_colors = explode(',', $new_colors);
			$old_colors = Yii::app()->session['korzina_color'];
			foreach($new_colors as $key => $value) {
				$old_colors[$value] = 1;
			}
			Yii::app()->session['korzina_color'] = $old_colors;

			// add new volumes to session
			$new_volumes = explode(',', $new_volumes);
			$old_volumes = Yii::app()->session['korzina_volume'];
			if (count($new_volumes)>0) {
				foreach($new_volumes as $key => $value) {
					$old_volumes[$value] = 1;
				}
			}

			Yii::app()->session['korzina_volume'] = $old_volumes;

			$this->save_size_colors($order_id);
		}

		Yii::app()->session['catalog_id'] = 0;

		$this->render('korzina', array(
			'order_id' => $order_id,
			'error' => $error
		));
	}

	public function actionTestEmail()
	{

		$this->send_mime_mail('Название от кого пришло - Ваше ФИО или название фирмы',
		               'dmin@leadsyou.ru', //Ваш емайл, или куда им отвечать на письмо
		               'adhamcoder@gmail.com, adham_uz22@mail.ru, adham_uz22@yahoo.com',  //куда письма рассылаем
		               'UTF-8',
		               'KOI8-R',
		               'Тема письма',
		               'Я пишу письмо большое, не плохое и кривое... Прочитай его без скуки В Бате или Аутлуке.. ну и так далее.. ');

			echo 'tomom';die;

		$message = new YiiMailMessage;

		$message->subject = 'mani testim';

		$content = 'qoni gurali';

		$message->setBody($content, 'text/html');

		$message->setTo(array('kate@fleshka.ru', 'adhamcoder@gmail.com'));

		$message->from = 'robot@fleshka.ru';

		// send email
		Yii::app()->mail->send($message);

		echo 'tomom';die;

	}

	function send_mime_mail($name_from, // имя отправителя
	                        $email_from, // email отправителя
	                        $email_to, // email получателя
	                        $data_charset, // кодировка переданных данных
	                        $send_charset, // кодировка письма
	                        $subject, // тема письма
	                        $body // текст письма
	                        )
	{
	  $to = $email_to;
	  $subject = $this->mime_header_encode($subject, $data_charset, $send_charset);
	  $from =  $this->mime_header_encode($name_from, $data_charset, $send_charset).' <' . $email_from . '>';
	  if($data_charset != $send_charset) {
	    $body = iconv($data_charset, $send_charset, $body);
	  }

	  $headers ="Content-type: text/html; charset=\"".$send_charset."\"\n";
	  $headers .="From: $from\n";
	  $headers .="Mime-Version: 1.0\n";

	  return mail($to, $subject, $body, $headers);
	}

	function mime_header_encode($str, $data_charset, $send_charset) {
	  if($data_charset != $send_charset) {
	    $str = iconv($data_charset, $send_charset, $str);
	  }
	  return '=?' . $send_charset . '?B?' . base64_encode($str) . '?=';
	}

	function send_email($order_id, $manager_id = 0)
	{

		$order = Morder::model()->find('order_id="'.$order_id.'"');

		// define whom to send email

		// if customer comments
		if ($manager_id==0) {

			$comments = $order->comments;

			$email = array();
			// if comments have before, send all manages who participace in conversation
			if (count($comments)>0) {

				foreach($comments as $comment) {

					if ($comment->manager_id>0 && $comment->manager->email!='') {
						$email[] = $comment->manager->email;
					}
				}

			}

			// if any managers don't participate in conversation, send email to all managers
			if (count($email)==0) {

				$managers = User::model()->findAll();

				foreach($managers as $manager) {

					if ($manager->email!='') {
						$email[] = $manager->email;
					}
				}
			}

		} else {
			// if manager comments, get customer's email
			$email[] = $order->email;
		}

		// get email template
		$email_template = EmailTemplate::model()->find('name="new_order"');

		if (count($email_template)>0) {

			$subject = $email_template->subject;

			$content = $email_template->content;

			if ($manager_id==0) {

				// content of email to manager

				$url = Yii::app()->createAbsoluteUrl('site/manager',array('order_id'=>$order_id));

				$content = str_replace('{LINK}', $url, $content);

				$content = str_replace('{NUMBER}', $oder->id, $content);

			} else {

				// content of email to customer

				$url = Yii::app()->createAbsoluteUrl('site/korzinka',array('order_id'=>$order_id));

				$content = str_replace('{LINK}', $url, $content);

				$content = str_replace('{NUMBER}', $oder->id, $content);

			}

			$emails = implode(", ", $email);

			// send email
			$this->send_mime_mail($email_template->from_name,
			               $email_template->from, //Ваш емайл, или куда им отвечать на письмо
			               $emails,  //куда письма рассылаем
			               'UTF-8',
			               'KOI8-R',
			               $email_template->subject,
			               $content);

		}
	}

	public function actionSendChatEmail()
	{
		$chat_name = $_POST['chat_name'];
		$chat_email = $_POST['chat_email'];
		$chat_text = $_POST['chat_text'];

		// send chat email to all managers

		$managers = User::model()->findAll();

		$email = array();
		foreach($managers as $manager) {

			if ($manager->email!='') {
				$email[] = $manager->email;
			}
		}

		$emails = implode(", ", $email);

		// send email
		$this->send_mime_mail($chat_name,
		               $chat_email, //Ваш емайл, или куда им отвечать на письмо
		               $emails,  //куда письма рассылаем
		               'UTF-8',
		               'KOI8-R',
		               'Запрос из fleshka.ru',
		               $chat_text);

	}

	public function actionManagerLogout()
	{
		unset(Yii::app()->session['user_id']);

		unset(Yii::app()->session['user']);

		Yii::app()->session['logoff'] = 1;

		$order_id = $_GET['order_id'];

		$this->redirect(array('site/manager', 'order_id' => $order_id));
	}

	public function actionManagerChat()
	{

		// manager logout
		$username = $_SERVER['PHP_AUTH_USER'];
		$password = $_SERVER['PHP_AUTH_PW'];

		$check = User::model()->checkUser($username, $password);

		// check user
		if (!$check) {

			// if login or password is incorrect
			unset($_SERVER['PHP_AUTH_USER']);
			unset($_SERVER['PHP_AUTH_PW']);

		} else {

			// if login and password is correct
			$this->redirect(array('site/chat'));
		}

		if ( !isset($_SERVER['PHP_AUTH_USER']) ) {

			header('WWW-Authenticate: Basic realm="You Shall Not Pass"');
			header('HTTP/1.0 401 Unauthorized');
			exit;

		}

	}

	public function actionManager()
	{
		// manager logout
		if (isset(Yii::app()->session['logoff']) && Yii::app()->session['logoff']==1) {

			unset($_SERVER['PHP_AUTH_USER']);
			unset($_SERVER['PHP_AUTH_PW']);

			unset(Yii::app()->session['logoff']);
		}

		$order_id = $_GET['order_id'];

		// manager logout
		$username = $_SERVER['PHP_AUTH_USER'];
		$password = $_SERVER['PHP_AUTH_PW'];

		$check = User::model()->checkUser($username, $password);

		// check user
		if (!$check) {

			// if login or password is incorrect
			unset($_SERVER['PHP_AUTH_USER']);
			unset($_SERVER['PHP_AUTH_PW']);

		} else {

			// if login and password is correct
			$this->redirect(array('site/korzinka', 'order_id' => $order_id));
		}

		if ( !isset($_SERVER['PHP_AUTH_USER']) ) {

			header('WWW-Authenticate: Basic realm="You Shall Not Pass"');
			header('HTTP/1.0 401 Unauthorized');
			exit;

		}

	}

	/**
	 * Download nanesiniye
	 */
	public function actionFile_download()
	{
		$file = $_GET['name'];

		$webroot = Yii::getPathOfAlias('webroot');

		MyClass::file_download($webroot . '/logos/' . $file, $file);
	}

	public function actionTestApc()
	{
		$result = '121';
		$cache_key = 'key_12';
		Yii::app()->cache->set($cache_key,$result,300);
		echo Yii::app()->cache->get($cache_key);// always return false
	}

	public function actionFixColorprice()
	{

		$sql = 'select * from colorprice1';

		$searches = Yii::app()->db->createCommand($sql)->query();

		if (count($searches)>0) {

			foreach ($searches as $search) {

				$sql = 'select * from colorprice1 where id='.$search['color_group'];

				$check_colorprice = Yii::app()->db->createCommand($sql)->query();

				if (count($check_colorprice)==0) {

					echo $search['ident'].' '.$search['id'].' '.$search['color_group'].'<br>';

				}

			}
		}

	}

	public function actionCatalog()
	{

		$webroot = Yii::getPathOfAlias('webroot');

		$type = $_GET['type'];

		if ($type=='in_stock') {

			$fleshkas = Descriptionsize::model()->findAll('trash=0 and instock=1');

			$file = 'fleshka.ru(nal)'.date('d.m.Y').'.pdf';

		} elseif ($type=='special') {

			$relgoodscatalogs = Relgoodscatalog::model()->with('descriptionsize')
					->findAll(array('condition' => 'descriptionsize.trash=0 and instock=1 and catalog_id=:id',
						'params' => array(':id' => 1),
						'order' => 'descriptionsize.id ASC'));

			if (count($relgoodscatalogs)>0) {

				$goods_id = '';

				foreach ($relgoodscatalogs as $relgoodscatalog) {

					$goods_id .= $relgoodscatalog->goods_id.',';
				}

				$goods_id .= '0';
			}
			$fleshkas = Descriptionsize::model()->findAll('id in ('.$goods_id.')');

			$file = 'fleshka.ru(special)'.date('d.m.Y').'.pdf';

		} else {

			$fleshkas = Descriptionsize::model()->findAll('trash=0 and instock=0');

			$file = 'fleshka.ru(zakaz)'.date('d.m.Y').'.pdf';

		}

			// $pdf = $this->renderPartial('pdf_fleshka_full',array(
			// 	'fleshkas' => $fleshkas
			// ));

			// return;

		$file_name = $webroot.'/dogovor/pdf/'.$file;

		if (!file_exists($file_name)) {

			ini_set('memory_limit', '-1');
			ini_set ( 'max_execution_time', 1200);

			//$pdf = $this->renderPartial('pdf_fleshka', array(
			$pdf = $this->renderPartial('pdf_fleshka_full', array(
				'fleshkas' => $fleshkas
			), true);

	        // mPDF
	        //$mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
	        //$mPDF1 = Yii::app()->ePdf->mpdf('', 'A4-L', '','','','','','','','','L');
	        $mPDF1 = Yii::app()->ePdf->mpdf('',    // mode - default ''
											'A4-L',    // format - A4, for example, default ''
										 	0,     // font size - default 0
											'',    // default font family
											15,    // margin_left
											15,    // margin right
											16,     // margin top
											16,    // margin bottom
											9,     // margin header
											9,     // margin footer
											'L');  // L - landscape, P - portrait

			// renderPartial (only 'view' of current controller)
			$mPDF1->WriteHTML($pdf);

			// Outputs ready PDF to file
	        $mPDF1->Output($file_name, 'F');

		}

		MyClass::file_download($file_name, $file);

	}

	function actionTestPdf()
	{

		$fleshka = Descriptionsize::model()->findByPk(495);

		foreach ($fleshka->colorprices as $colorprice) {

			foreach ($colorprice->photoss as $photo) {

				echo '<img src="data:image/jpeg;base64, '.base64_encode( $photo->body).'"/>';
			}
		}

		return;

  //       $html2pdf = Yii::app()->ePdf->HTML2PDF('', 'A5');
  //       $html2pdf->WriteHTML('jjjj');
  //       $html2pdf->Output();

		// return;

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A5');

        # render (full page)
        //$mPDF1->WriteHTML($this->render('index', array(), true));

        # Load a stylesheet
        // $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
        // $mPDF1->WriteHTML($stylesheet, 1);

        # renderPartial (only 'view' of current controller)
        //$mPDF1->WriteHTML($this->renderPartial('index', array(), true));
        $mPDF1->WriteHTML('this is test');

        # Renders image
        //$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));

        # Outputs ready PDF
		$webroot = Yii::getPathOfAlias('webroot');

		$file = 'fleshka.ru'.date('d.m.Y').'.pdf';
		$file_name = $webroot.'/dogovor/pdf/'.$file;
        $mPDF1->Output($file_name, 'F');

		MyClass::file_download($file_name, $file);

	}

	public function actionPicture()
	{
		$file = key($_GET);

		$pathinfo = pathinfo($file);

		$photo_id = $pathinfo['filename'];

		$photo = Photos::model()->findByPk($photo_id);

		if (count($photo)>0) {

			$image = $photo->thumbnail;

			header('Content-type: image/jpeg');

			print $image;
			exit;
		}

	}

    public function actionChat()
    {

    	if (!isset(Yii::app()->session['user_id'])) {

    		$this->redirect(Yii::app()->createUrl('site/managerChat'));
    	}

        $this->renderPartial('chat', array(

        	));
    }

    public function actionReloadChatList()
    {
    	$chats = $this->get_chats();

		if (count($chats)>0) {

			foreach($chats as $key => $chat) {

				$count = $this->get_new_messages_count($chat->hash);

				echo '<a href="javascript:see_chat(\''.$chat->hash.'\')">user '.substr($chat->hash,-4).'</a>'.($count>0?' <span class="'.$chat->hash.'">('.$count.')</span>':'').'<br>';

			}

		}

    }

    function get_new_messages_count($hash)
    {
    	$criteria = new CDbCriteria;

		$criteria->condition = 'status=1 && hash="'.$hash.'"';

		$chats = Chatwindow::model()->findAll($criteria);

		return count($chats);
    }

    public function get_chats()
    {
    	$criteria = new CDbCriteria;

    	$date_from = date('Y-m-d 0:0:0');

    	$date_to = date('Y-m-d 23:59:59');

    	$criteria->condition = 'lastmessagedate>="'.$date_from.'" and lastmessagedate<="'.$date_to.'"';

    	$criteria->group = 'hash';

    	$chats = Chatwindow::model()->findAll($criteria);

    	return $chats;

    }

    public function actionCustomerChatStatus()
    {
    	$criteria = new CDbCriteria;

    	$date_from = date('Y-m-d 0:0:0');

    	$date_to = date('Y-m-d 23:59:59');

    	$criteria->condition = 'lastmessagedate>="'.$date_from.'" and lastmessagedate<="'.$date_to.'" and status=1';

    	$chats = Chatwindow::model()->findAll($criteria);

    	if (count($chats)>0) {
    		echo 1;
    	} else {
    		echo 3;
    	}

    }

    public function actionCustomerChat()
    {
    	$method = $_POST['method'];

    	if (isset($_POST['hash'])) {

    		$hash = $_POST['hash'];
    		$this->set_chat_status_to_read($hash);

    	} else {

	    	@session_start();
	    	$hash = session_id();
    	}

    	if ($method=='fetch') {

	    	$criteria = new CDbCriteria;

	    	$criteria->condition = 'hash="'.$hash.'"';

	    	$criteria->order = 'lastmessagedate asc';

	    	$messages = Chatwindow::model()->findAll($criteria);

	    	if (count($messages)>0) {

	    		foreach($messages as $message) {

					echo '<div class="text">';
		    			if ($message->manager_id==0) {
		    				echo '<div style="color:#5BA0D0;float:left;">'.date('h:i:s', strtotime($message->lastmessagedate)).'→&nbsp;</div>'.$message->message;
		    				echo '<div style="clear:both;"></div>';
		    			} else {
		    				$manager = User::model()->findByPk($message->manager_id);
		    				echo '<div style="color:#5BA0D0;float:left;">'.date('h:i:s', strtotime($message->lastmessagedate)).' '.$manager->fio.':&nbsp;</div>'.$message->message;
		    			}
	    			echo '</div>';

	    		}
	    	}
    	}

    	if ($method=='throw') {

    		if (isset(Yii::app()->session['user_id'])) {

	    		$hash = $_POST['hash'];
	    		$manager_id = Yii::app()->session['user_id'];
	    		$status = 2; // read

	    		// change status to read
	    		$this->set_chat_status_to_read($hash);

    		} else {

	    		$manager_id = 0;
	    		$status = 1; // new

    		}

    		$message = $_POST['message'];

    		$chatwindow = new Chatwindow;
    		$chatwindow->hash = $hash;
    		$chatwindow->message = $message;
    		$chatwindow->manager_id = $manager_id;
    		$chatwindow->status = $status; // new
    		$chatwindow->lastmessagedate = date('Y-m-d h:i:s');
    		$chatwindow->save();

    	}

    }

    function set_chat_status_to_read($hash)
    {
    	// change status to read
		$all_chat_windows = Chatwindow::model()->findAll('hash="'.$hash.'"');

		if (count($all_chat_windows)>0) {

			foreach($all_chat_windows as $all_chat_window) {
				$all_chat_window->status = 2;
				$all_chat_window->save();
			}
		}
    }

    public function actionSaveWindowWidth()
    {
    	Yii::app()->session['windowWidth'] = $_POST['windowWidth'];
    }

}