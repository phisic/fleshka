<?php

class FleshkaController extends Controller
{

	public $title = 'Флешка';

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
		Yii::app()->setGlobalState('top_menu', 'fleshka');

		$this->title = 'Флешка';

		$fleshkas = Descriptionsize::model()->findAll('trash=0');

		$this->render('index', array(
			'fleshkas' => $fleshkas
		));
	}

	public function actionReloadFleshka()
	{

		$fleshkas = Descriptionsize::model()->findAll('trash=0');

		echo '<ul>';
			echo '<li class="fleshka_list" fleshka_id="0">Создать</li>';

			foreach($fleshkas as $fleshka) {

				echo '<li class="fleshka_list" fleshka_id="'.$fleshka->id.'">'.$fleshka->name.' #'.$fleshka->id.'</li>';

			}
		echo '</ul>';

	}

	public function actionUpakovka()
	{
		Yii::app()->setGlobalState('top_menu', 'upakovka');

		$this->title = 'Упаковка';

		$upakovkas = Descriptionprice::model()->findAll('trash=0');

		$this->render('upakovka', array(
			'upakovkas' => $upakovkas
		));		
	}

	public function actionReloadUpakovka()
	{

		$upakovkas = Descriptionprice::model()->findAll('trash=0');

		echo '<ul>';
			echo '<li class="fleshka_list" fleshka_id="0">Создать</li>';

			foreach($upakovkas as $upakovka) {

				echo '<li class="fleshka_list" fleshka_id="'.$upakovka->id.'">'.$upakovka->name.' #'.$upakovka->id.'</li>';

			}
		echo '</ul>';

	}

	public function actionEdit()
	{
		$id = $_POST['id'];

		if ($id>0) {

			$fleshka = Descriptionsize::model()->findByPk($id);

		} else {

			$fleshka = new Descriptionsize;
		}

		$this->renderPartial('edit', array(
			'fleshka' => $fleshka
		));
	}

	public function actionUpakovkaEdit()
	{
		$id = $_POST['id'];

		if ($id>0) {

			$upakovka = Descriptionprice::model()->findByPk($id);

		} else {

			$upakovka = new Descriptionprice;
		}

		$this->renderPartial('upakovkaEdit', array(
			'upakovka' => $upakovka
		));
	}

	public function actionSpecial()
	{
		Yii::app()->setGlobalState('top_menu', 'special');

		$this->title = 'Специальные предложения';

		$fleshkas = Descriptionsize::model()->findAll();

		$this->render('special', array(
			'fleshkas' => $fleshkas,
		));
	}

	public function actionPopular()
	{
		Yii::app()->setGlobalState('top_menu', 'popular');

		$this->title = 'Популярные флешки';

		$fleshkas = Descriptionsize::model()->findAll();

		$this->render('popular', array(
			'fleshkas' => $fleshkas,
		));
	}

	public function actionDelete()
	{
		$id = $_POST['id'];

		$fleshka = Descriptionsize::model()->findByPk($id);

		$fleshka->trash = 1;

		$fleshka->save();
	}

	public function actionUpakovkaDelete()
	{
		$id = $_POST['id'];

		$upakovka = Descriptionprice::model()->findByPk($id);

		$upakovka->trash = 1;

		$upakovka->save();
	}

	public function actionSpecialDelete()
	{
		$id = $_POST['id'];
		Relgoodscatalog::model()->deleteByPk($id);		
	}

	public function actionPopularDelete()
	{
		$id = $_POST['id'];
		Popular::model()->deleteByPk($id);
	}

	public function actionSpecialShow()
	{

		$criteria = new CDbCriteria;

		$criteria->condition = 'catalog_id=1';

        $specialoffer = new CActiveDataProvider('Relgoodscatalog', array(
                        'criteria'   => $criteria,
                        'pagination' => false
                ));

		$this->renderPartial('specialView', array(
			'specialoffer' => $specialoffer,
		));

	}

	public function actionPopularShow()
	{

        $popular = new CActiveDataProvider('Popular', array(
                        'pagination' => false
                ));

		$this->renderPartial('popularView', array(
			'popular' => $popular,
		));

	}

	public function actionSpecialAdd()
	{
		$fleshka_id = $_POST['fleshka_id'];

		$specialoffer = Relgoodscatalog::model()->find('goods_id='.$fleshka_id.' and catalog_id=1');

		if (count($specialoffer)==0) {

			$specialoffer = new Relgoodscatalog();

			$specialoffer->catalog_id = 1;

			$specialoffer->goods_id = $fleshka_id;

			$specialoffer->save();

		}
	}

	public function actionPopularAdd()
	{
		$fleshka_id = $_POST['fleshka_id'];

		$popular = Popular::model()->find('fleshka_id='.$fleshka_id);

		if (count($popular)==0) {

			$popular = new Popular();

			$popular->fleshka_id = $fleshka_id;

			$popular->save();

		}
	}

	public function actionSave()
	{
		$data = $_POST['Descriptionsize'];

		$id = $_POST['id'];

		if ($id>0) {
			$descriptionsize = Descriptionsize::model()->findByPk($id);
		} else {
			$descriptionsize = new Descriptionsize;
			$last_id = $this->getFleshkaUniqueId();
			$descriptionsize->id = $last_id;
		}

		$descriptionsize->attributes = $data;
		$descriptionsize->save();

		$last_id = Yii::app()->db->getLastInsertId();
		$id = $last_id;

		$search = new Msearch;
		$search->goods_id = $last_id;
		$search->word = 'Флешка.рф';
		$search->save();

		$search = new Msearch;
		$search->goods_id = $last_id;
		$search->word = '#'.$last_id;
		$search->save();

		$search = new Msearch;
		$search->goods_id = $last_id;
		$search->word = $last_id;
		$search->save();

		// $result = 'Успешно изменен';

		echo $id;
	}

	public function actionUpakovkaSave()
	{
		$data = $_POST['Descriptionprice'];

		$id = $_POST['id'];

		if ($id>0) {

			$descriptionprice = Descriptionprice::model()->findByPk($id);

		} else {

			$descriptionprice = new Descriptionprice;

			$criteria = new CDbCriteria;

			// get unique id from descriptiosize and descriptionprice
			$last_id = $this->getFleshkaUniqueId();

			$descriptionprice->id = $last_id;

			$id = $last_id;

		}

		$descriptionprice->attributes = $data;

		$descriptionprice->save();

		$search = new Msearch;
		$search->goods_id = $id;
		$search->word = 'Флешка.рф';
		$search->save();

		$search = new Msearch;
		$search->goods_id = $id;
		$search->word = '#'.$id;
		$search->save();

		$search = new Msearch;
		$search->goods_id = $id;
		$search->word = $id;
		$search->save();

		// $result = 'Успешно изменен';

		echo $id;
	}

	public function actionShowPhoto() 
	{
		$fleshka_id = $_POST['fleshka_id'];
		$mycolorprice = $_POST['mycolorprice'];
		$colorprice_id = $_POST['colorprice_id'];

		$fleshka = Descriptionsize::model()->findByPk($fleshka_id);

		$this->renderPartial('color_photo', array(
			'fleshka'=>$fleshka,
			'my_colorprice'=>$mycolorprice,
			'colorprice_id'=>$colorprice_id
		));
	}

	public function actionUpakovkaShowPhoto() 
	{
		$upakovka_id = $_POST['upakovka_id'];
		$mycolorprice = $_POST['mycolorprice'];
		$colorprice_id = $_POST['colorprice_id'];

		$upakovka = Descriptionprice::model()->findByPk($upakovka_id);

		$this->renderPartial('upakovka_color_photo', array(
			'upakovka'=>$upakovka,
			'my_colorprice'=>$mycolorprice,
			'colorprice_id'=>$colorprice_id
		));
	}

	public function actionDeletePhoto()
	{
		$photos_id = $_POST['photos_id'];

		Photos::model()->deleteByPk($photos_id);
	}

	public function actionDelete_color()
	{
		$fleshka_id = $_POST['fleshka_id'];

		$colorprice_id = $_POST['colorprice_id'];

		echo $colorprice_id;

		Photos::model()->deleteAll('ident='.$colorprice_id);

		Colorprice::model()->deleteByPk($colorprice_id);

	}

	public function actionShowpp()
	{
		$photo = Photos::model()->findByPk(5346);

		echo '<img src="data:image/jpeg;base64, '.base64_encode( $photo->body).'"/>';
		echo '<br>';
		echo '<img src="data:image/jpeg;base64, '.base64_encode( $photo->thumbnail).'"/>';

		$photo = Photos::model()->findByPk(5261);

		echo '<img src="data:image/jpeg;base64, '.base64_encode( $photo->body).'"/>';
		echo '<br>';
		echo '<img src="data:image/jpeg;base64, '.base64_encode( $photo->thumbnail).'"/>';

	}

	public function actionUploadPhoto()
	{

        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        
        // max file size in bytes
        $sizeLimit = 2 * 1024 * 1024;

		$base_path = Yii::getPathOfAlias('webroot').'/logos/';

		// get uploaded file content        
        $uploader = new UploadHelper($allowedExtensions, $sizeLimit);
        //$result = $uploader->returnContent();
        $upload = $uploader->handleUpload($base_path);

        // if uploaded successfully
        if ($upload) {

	        $filename = $base_path.$upload['filename'];

			// resize it
        	$obj = new MyImage();
        	//set maximum width within wich the image should be resized
        	$obj->max_width(600);
	        // set maximum height within wich the image should be resized
	        // for example size of the area in which image to be displayed
	        $obj->max_height(450);
    	    $obj->image_path($filename);
        	//call the functio to resize the image
        	$obj->image_resize();

			$handle = fopen($filename, "rb");
			$img = fread($handle, filesize($filename));
			fclose($handle);

			//$result = base64_encode($img);
			$result_body = $img;


        	$obj = new MyImage();
        	//set maximum width within wich the image should be resized
        	$obj->max_width(280);
	        // set maximum height within wich the image should be resized
	        // for example size of the area in which image to be displayed
	        $obj->max_height(210);
    	    $obj->image_path($filename);
        	//call the functio to resize the image
        	$obj->image_resize();

			$handle = fopen($filename, "rb");
			$img = fread($handle, filesize($filename));
			fclose($handle);

			//$result = base64_encode($img);
			$result_thumbnail = $img;

			// delete uploaded image
			@unlink($filename);

        }


        $fleshka_id = $_GET['fleshka_id'];
        $color_id = $_GET['color_id'];
        $photos_id = $_GET['photos_id'];        

        $colorprice = Colorprice::model()->find('ident='.$fleshka_id.' and color_id='.$color_id);

        //$colorprice_id = Yii::app()->db->getLastInsertID();
        $colorprice_id = $colorprice->id;

        // $colorprice = Colorprice::model()->findByPk($colorprice_id);
        // $colorprice->color_group = $colorprice->id;
        // $colorprice->save();


        if ($photos_id>0) {
			$photos = Photos::model()->findByPk($photos_id);
        } else {
        	$photos = new Photos;
	        $photos->ident = $colorprice_id;
        }
        
		$photos->body = $result_body;
        $photos->thumbnail = $result_thumbnail;
        $photos->save();
        
        // to pass data through iframe you will need to encode all html tags
        //echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);

	}

	public function actionNewColor() 
	{
		$colors = Colors::model()->findAll();

		$fleshka_id = $_POST['fleshka_id'];

		$colorprice_id = isset($_POST['colorprice_id'])?$_POST['colorprice_id']:0;

		$color_group = isset($_POST['color_group'])?$_POST['color_group']:0;

		if ($colorprice_id>0) {

			$colorprice = Colorprice::model()->findByPk($colorprice_id);

			$color_id = $colorprice->color_id;

		} else {

			$color_id = 0;
		}

		$this->renderPartial('new_color', array(
			'fleshka_id' => $fleshka_id,
			'colors' => $colors,
			'colorprice_id' => $colorprice_id,
			'color_id' => $color_id,
			'color_group' => $color_group
		));
	}

	public function actionSaveColor()
	{
		$colorprice_id = $_POST['colorprice_id'];

		$fleshka_id = $_POST['fleshka_id'];

		$color_group = $_POST['color_group'];

		$color_id = $_POST['color_id'];

		if ($colorprice_id>0) {

			$colorprice = Colorprice::model()->findByPk($colorprice_id);
			$colorprice->color_id = $color_id;

		} else {

			$colorprice = new Colorprice;
			$colorprice->ident = $fleshka_id;

			$colorprice->color_id = $color_id;

			if ($color_group==0) {

				if ($colorprice->save()) {
					$last_id = Yii::app()->db->getLastInsertId();
				}

				$colorprice = Colorprice::model()->findByPk($last_id);
				$color_group = $last_id;
			}

			$colorprice->color_group = $color_group;

		}

		$colorprice->save();

	}

	public function actionEditColor()
	{
		$fleshka_id = $_POST['fleshka_id'];
		$colorprice_id = $_POST['colorprice_id'];

		$colorprices = Colorprice::model()->findAll('color_group='.$colorprice_id);

		$this->renderPartial('edit_color', array(
			'fleshka_id' => $fleshka_id,
			'colorprices' => $colorprices,
			'colorprice_id' => $colorprice_id
		));

	}

	public function actionEditCatalog()
	{
		$fleshka_id = $_POST['fleshka_id'];
		$rel_id = $_POST['rel_id'];
		$relgoodcatalog = Relgoodscatalog::model()->findByPk($rel_id);

		$catalogs = Catalogs::model()->findAll();

		$this->renderPartial('edit_catalog', array(
			'fleshka_id' => $fleshka_id,
			'rel_id' => $rel_id,
			'catalogs' => $catalogs,
			'relgoodcatalog' => $relgoodcatalog
		));
	}

	public function actionUpakovkaEditCatalog()
	{
		$upakovka_id = $_POST['upakovka_id'];
		$rel_id = $_POST['rel_id'];
		$relgoodcatalog = Relgoodscatalog::model()->findByPk($rel_id);

		$catalogs = Catalogs::model()->findAll();

		$this->renderPartial('upakovka_edit_catalog', array(
			'upakovka_id' => $upakovka_id,
			'rel_id' => $rel_id,
			'catalogs' => $catalogs,
			'relgoodcatalog' => $relgoodcatalog
		));
	}


	public function actionSave_catalog()
	{
		$fleshka_id = $_POST['fleshka_id'];
		$rel_id = $_POST['rel_id'];
		$catalog_id = $_POST['catalog_id'];

		if ($rel_id>0) {

			$relgoodcatalog = Relgoodscatalog::model()->findByPk($rel_id);
		} else {

			$relgoodcatalog = new Relgoodscatalog;
			$relgoodcatalog->goods_id = $fleshka_id;
		}

		$relgoodcatalog->catalog_id = $catalog_id;

		$relgoodcatalog->save();

	}

	public function actionSave_upakovka_catalog()
	{
		$upakovka_id = $_POST['upakovka_id'];
		$rel_id = $_POST['rel_id'];
		$catalog_id = $_POST['catalog_id'];

		if ($rel_id>0) {

			$relgoodcatalog = Relgoodscatalog::model()->findByPk($rel_id);
		} else {

			$relgoodcatalog = new Relgoodscatalog;
			$relgoodcatalog->goods_id = $upakovka_id;
		}

		$relgoodcatalog->catalog_id = $catalog_id;

		$relgoodcatalog->save();

	}

	public function actionCatalogs()
	{
		$fleshka_id = $_POST['fleshka_id'];

		$fleshka = Descriptionsize::model()->findByPk($fleshka_id);

		$this->renderPartial('catalogs', array(
			'fleshka' => $fleshka,
			'flehska_id' => $fleshka_id,
		));
	}

	public function actionUpakovkaCatalogs()
	{
		$upakovka_id = $_POST['upakovka_id'];

		$upakovka = Descriptionprice::model()->findByPk($upakovka_id);

		$this->renderPartial('upakovkaCatalogs', array(
			'upakovka' => $upakovka,
			'upakovka_id' => $upakovka_id,
		));
	}

	public function actionDelete_catalog()
	{
		$rel_id = $_POST['rel_id'];
		Relgoodscatalog::model()->deleteByPk($rel_id);
	}

	public function actionSearch()
	{
		$fleshka_id = $_POST['fleshka_id'];

		$fleshka = Descriptionsize::model()->findByPk($fleshka_id);

		$this->renderPartial('search', array(
			'flehska_id' => $fleshka_id,
			'fleshka' => $fleshka
		));
	}

	public function actionUpakovka_search()
	{
		$upakovka_id = $_POST['upakovka_id'];

		$upakovka = Descriptionprice::model()->findByPk($upakovka_id);

		$this->renderPartial('upakovkaSearch', array(
			'upakovka_id' => $upakovka_id,
			'upakovka' => $upakovka
		));
	}

	public function actionSave_search()
	{
		$fleshka_id = $_POST['fleshka_id'];
		$word = $_POST['word'];

		$word_list = explode(',', $word);

		Msearch::model()->deleteAll('goods_id='.$fleshka_id);

		if (count($word_list)>0) {

			foreach($word_list as $list) {

				$search = new Msearch;				
				$search->goods_id = $fleshka_id;
				$search->word = trim($list);
				$search->save();
			}
		}

	}

	public function actionSave_upakovka_search()
	{
		$upakovka_id = $_POST['upakovka_id'];
		$word = $_POST['word'];

		$word_list = explode(',', $word);

		Msearch::model()->deleteAll('goods_id='.$upakovka_id);

		if (count($word_list)>0) {

			foreach($word_list as $list) {

				$search = new Msearch;				
				$search->goods_id = $upakovka_id;
				$search->word = trim($list);
				$search->save();
			}
		}

	}

	public function actionCalculation()
	{

		if (isset($_POST['price300'])) {

			$calculation = Content::model()->find('name="calculation"');

			$price['price300'] = $_POST['price300'];
			$price['price500'] = $_POST['price500'];
			$price['price1000'] = $_POST['price1000'];
			$price['price_zakaz'] = $_POST['price_zakaz'];

			$s_price = serialize($price);

			$calculation->content = $s_price;
			$calculation->save();

		}


		Yii::app()->setGlobalState('top_menu', 'calculation');

		$this->title = 'Калькуляция';

		$calculation = Content::model()->find('name="calculation"');

		$calculation_array = unserialize($calculation->content);

		$this->render('calculation', array(
			'calculation' => $calculation_array
		));
	}

	function getFleshkaUniqueId()
	{
		$sql = 'select max(id) as max_id from descriptionsize';

		$items = Yii::app()->db->createCommand($sql)->queryAll();

		$max_id = $items[0]['max_id'];

		$sql = 'select max(id) as max_id from descriptionprice';

		$items = Yii::app()->db->createCommand($sql)->queryAll();

		$max_id1 = $items[0]['max_id'];

		if ($max_id<$max_id1) {
			$max_id = $max_id1;
		}

		$max_id += 1;

		return $max_id;
	}

}
