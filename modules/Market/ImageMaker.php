<?php
class Market_ImageMaker extends Market_ColorMaker{
    function __toString() {
        $this->ZZ('H.selected')->switchBy(in_array((string)$this->getAttribute('id'), $this->selected)?'':'.n');

        return zzTml::__toString();
    }
}