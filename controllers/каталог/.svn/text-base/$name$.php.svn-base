<?php
class zzRoot extends zzSite {
    protected $rootPath = __FILE__;

    function doInit(){
        if (!$this->urlVars['name'] || $this->urlVars['name'] == 'index'){
            $this->urlVars['name'] = '';
        }
        
        zzNew('zzView')->redirect('/прайс/'.$this->urlVars['name']);
    }
}
