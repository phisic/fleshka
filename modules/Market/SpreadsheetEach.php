<?php
class Market_SpreadsheetEach extends Each_Value{
    public $keys = array();
    public $cols = array();

    function onEachInit($spreadsheet){
        return Market_Spreadsheet::onEachInit($spreadsheet);
    }

    function onEach($index, $value){
        Market_Spreadsheet::onEach($index, $value);

        return parent::onEach($index, $value);
    }
}

