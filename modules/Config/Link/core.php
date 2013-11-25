<?php
if (RELEASE)
    define ('CONFIG_PATH', dirname(__FILE__).'/LinkRelease.zzTml');
else
    define ('CONFIG_PATH', dirname(__FILE__).'/Link.zzTml');

class Config_Link extends zzTml{
    protected function setupChildListClass($node){
        $this->ChildListClass = new zzTml_ChildList($this);
        $this->ChildListClass->append($node, CONFIG_PATH);

        return $this;
    }
}