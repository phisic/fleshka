<?php
class _ChangeGoods extends JSAction{
    function onOk($get){
        zzNew('Market_Db_Flashrf_Order')->updateGoods(array('order_id' => $this->getParameter('order_id'))+(array)$get);
        
        zzNew('zzView')->setStringView('123');
    }
}

class _AddNewGoods extends Link_Href{
    public function  __toString() {
        $this->setParameters(array(
            $this->getPrefixName() => $this->getPrefix()
        ));

        $href = zzClasses::create('Qs')
            ->setAttributes(
                $this->getParameters()
            )->setParameters(array('glue' => '&'));

        $this->setAttributes(array(
            'href' => '?'.$href
        ));

        return zzTml::__toString();
    }
    
    function onOk($get){
        $cookie = zzNew('Source_Cookie');
        $cookie->offsetSet('order_id', $this->getParameter('order_id'), 86400);
        $cookie->offsetSet('colors', '');
        $cookie->offsetSet('sizes', '');
        
        zzNew('zzView')->redirect('/прайс/');
    }
}

class _FormAddComment extends Form{
    function onError(){
        parent::onError();

        $this->ZZ('O.form')->switchBy('.submit');
    }

    function onOk($fields){
        $this->ZZ('O.form')->switchBy('.submit');

        $values = $this->getFieldsValues($fields);

        if (empty($values['comment']))
            return;

        $orderId = (string)$this->getParameter('order_id');
        
        $cookie = zzNew('Source_Cookie');
        
        $manager = $cookie->offsetExists('manager')?zzNew('Source_Cookie')->offsetGet('manager'):0;

        if ((string)$this->getParameter('order_state') != 3){
            $mail = zzNew('Mail_OrderComment')
                ->setParameters(array( 'order_id' => $orderId ));
                    
                    
            if ($manager)
                $mail->emailTo(array( (string)$this->getParameter('order_email') ));
            else
                $mail->emailTo(
                    array('eldar@100zakazov.ru', 'director@100zakazov.ru', 'liz2k.b8@gmail.com')
                );
            
            $mail->emailFrom('fleshka.ru', 'robot@usbflash.ru', 'eldar@100zakazov.ru')
                 ->send('Новый комментарий в запросе fleshka.ru');

        }

        zzNew('Market_Db_Flashrf_OrderComments')->create(array(
            'order_id' => $orderId,
            'manager_id' => $manager
        ) + $values);
        
        zzNew('zzView')->redirect();
    }
}

class _FormSaveCompanyInfo extends Form{
    function onOk($fields){
        $values = $this->getFieldsValues($fields);

        zzNew('Market_Db_Flashrf_Order')->saveCompanyInfo(
            array('order_id' => $this->getParameter('order_id')) + $values,
        true);

        zzNew('zzView')->redirect();
    }
}

class _DateExpireAction extends JSAction{
    function onOk($get){
        $values = (array)$get;
        
        if (isset($values['date_expire']))
            zzNew('Market_Db_Flashrf_Order')->updateDateExpire(array(
                'order_id' => $this->getParameter('order_id')
            ) + $values);

        if (isset($values['date_expire_to']))
            zzNew('Market_Db_Flashrf_Order')->updateDateExpireTo(array(
                'order_id' => $this->getParameter('order_id')
            ) + $values);

        if (isset($values['delivery']))
            zzNew('Market_Db_Flashrf_Order')->updateDelivery(array(
                'order_id' => $this->getParameter('order_id')
            ) + $values);

        if (isset($values['group']) && zzNew('Source_Cookie')->exists('manager'))
            zzNew('Market_Db_Flashrf_Order')->updateGroup(array(
                'order_id' => $this->getParameter('order_id')
            ) + $values);

        zzNew('zzView')->setStringView('');
    }
}

class zzRoot extends zzSite {
    protected $rootPath = __FILE__;

    function doInit(){
        $goods = zzNew('Market_Goods');
        if (!$goods->loadGoodsFromOrder( $this->urlVars['order'] )){
            zzNew('zzView')->redirect('/прайс/');
            return;
        }
        
        if (zzNew('Source_Get')->offsetExists('color'))
            $goods->filterGoodsByColor( zzNew('Source_Get')->get('color') );
        
        $goods->tmlSetup($this);
        
        $order = zzNew('Market_Order');
        $order->load( $this->urlVars['order'] );
        $order->tmlSetup($this);
        
        $cookie = zzNew('Source_Cookie');
        if (!$cookie->offsetExists('manager')){
            if ($cookie->offsetExists('myorders')){
                $orders = explode('_', $cookie->offsetGet('myorders'));
                if (!in_array($this->urlVars['order'], $orders))
                    $orders[] = $this->urlVars['order'];

                $cookie->offsetSet('myorders', implode('_', $orders), 86400);
            }else{
                $cookie->offsetSet('myorders', $this->urlVars['order']);
            }
        }
        
        $this->ZZ('Market_Goods_MenuSelect')->each('checkFor', array( $this->urlVars['order'] ));
    }
}