<?php
class _Autocomplete extends JSAction_Autocomplete{
    function  onAutocomplete($input) {
        return zzNew('Market_Db_Supplier_SupportTypes')->findSupportTypes(array('name' => trim($input)));
    }
}

class _AutocompleteEdit extends _Autocomplete{}


class _EditAction extends JSAction{
    function onOk($get){
        $values = zzNew('Market_Db_Supplier_Supplier')->adminLoad($get, true);

        if (count($values)){
            $this->ZZ('Form')->each('setDefaultFieldValues', array(
                $values
            ));
            
            $this->setParameters(array('id' => $values['id'], 'filename' => $values['filename'])); 
        }else{
            $this->ZZ('O.delete')->each('hide');
        }

        $this->viewInsideNodes();
    }
}

class _FormEdit extends Form{
    function onOk($fields){
        $values = $this->getFieldsValues($fields);
        
        if ($values['pricelist'])
            $values['pricelist'] = file_get_contents ($values['pricelist']);
        
        if (!$values['id'])
            zzNew('Market_Db_Supplier_Supplier')->adminInsertNew($values);
        else
            zzNew('Market_Db_Supplier_Supplier')->adminUpdate($values);
    }

    function onError(){
        parent::onError();

        foreach ($this->ZZ('Form_Fields')->toArray() as $node)
            if ($node->getErrors())
                $node->setAttributes(array('class' => 'error'));
    }
}

class _Delete extends Link{
    function onOk($get){
        zzNew('Market_Db_Supplier_Supplier')->adminRemove(array('id' => $get['id']));
        
        zzNew('zzView')->redirect();
    }
}

class _FormSearch extends Form{
    function onOk($fields){
        $values = $this->getFieldsValues($fields);

        zzNew('zzRoot')->ZZ('}.sup')->each('setSource', array(
            zzSql::Source('Market_Db_Supplier_Supplier')->adminLoadFilter($values)
        ));
    }
}

class _DLPriceLink extends Link{
    function onOk($get){
        $values = zzNew('Market_Db_Supplier_Supplier')->adminPriceLoad($get, true);
        
        zzNew('zzView')->setStringView($values['file'])->setHeader(
            new Header_Download($values['filename'])
        );
    }
}

class zzRoot extends zzSite {
    protected $rootPath = __FILE__;

    function doInit(){
        $this->ZZ('}.sup')->each('setSource', array(
            zzSql::Source('Market_Db_Supplier_Supplier')->adminLoadAll()
        ));
    }
}