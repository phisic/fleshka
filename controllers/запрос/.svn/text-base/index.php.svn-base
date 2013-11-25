<?php
class _FormCreateOrder extends Form{
    function onError(){
        parent::onError();

        $this->ZZ('O.form')->switchBy('.submit');
    }

    function isValid($form) {
        $cookie = zzNew('Source_Cookie');
        if ($cookie->offsetExists('sizes') && $cookie->offsetExists('colors')){
            /* test for goods */
            /* remove from here and add to TestField */
            return true;
        }
        
        return false;
    }
    
    function getUniqId(){
        $time = preg_replace('~[/+=]~','',base64_encode(pack('H*', md5(time()))));

        return $time;
    }

    function onOk($fields){
        $this->ZZ('O.form')->switchBy('.submit');

        $values = $this->getFieldsValues($fields);
        
        $cookie = zzNew('Source_Cookie');
        
        $values['sizes'] = $cookie->offsetGet('sizes');
        $values['colors'] = $cookie->offsetGet('colors');
        
        //create new order
        $orderId = $this->getUniqId();
        
        $values['order_id'] = $orderId;
        
        zzNew('Market_Db_Flashrf_Order')->create( $values );
        
        /* is Manager */
        if ($cookie->offsetExists('manager')){
            $values['manager_id'] = $cookie->offsetGet('manager');
        }else
            $values['manager_id'] = 0;        
        
        /* have comment */
        if ($values['comment'])
            zzNew('Market_Db_Flashrf_OrderComments')->create( $values );
            
        //save email for year
        $cookie->offsetSet('email', $values['email'], 86400*365);

        $cookie->offsetUnset('colors');
        $cookie->offsetUnset('sizes');
        
        //set old company (by email)
        $company = zzNew('Market_Db_Flashrf_Order')->companyInfoByEmail(array('email' => $values['email']), true);

        if (count($company))
            zzNew('Market_Db_Flashrf_Order')->setCompany(
                    array('order_id' => $orderId, 'state' => 1) + 
                    (array)$company);

        //send Email
        if ($values['manager_id']){
            zzNew('Mail_OrderCreated')
                ->setParameters(array( 'order_id' => $orderId ))
                ->emailTo(array($values['email']))
                ->emailFrom('fleshka.ru', 'robot@usbflash.ru', 'eldar@100zakazov.ru')
                ->send('На fleshka.ru для вас был создан запрос');
        }else{
            zzNew('Mail_NewOrder')
                ->setParameters(array( 'email' => $values['email'] ))
                ->emailTo(array('eldar@100zakazov.ru', 'director@100zakazov.ru', 'liz2k.b8@gmail.com'))
                ->emailFrom('fleshka.ru', 'robot@usbflash.ru', 'eldar@100zakazov.ru')
                ->send('На fleshka.ru был создан запрос');
        }
        
        zzNew('zzView')->redirect($orderId);
    }
}

class zzRoot extends zzSite {
    protected $rootPath = __FILE__;

    function doInit(){
        $goods = zzNew('Market_Goods');
        if (!$goods->loadGoodsFromOrderCookie()){
            die();
        }
        
        if (zzNew('Source_Get')->offsetExists('color'))
            $goods->filterGoodsByColor( zzNew('Source_Get')->offsetGet('color') );
        
        $goods->tmlSetup($this);
        
        $cookie = zzNew('Source_Cookie');
        
        if ($cookie->offsetExists('email'))
            $this->ZZ('Input.email')->each('setAttributes', array(array('value' => $cookie->offsetGet('email'))));
        
        $this->ZZ('Market_Goods_MenuSelect')->each('checkFor', array( "new" ));
    }
}
