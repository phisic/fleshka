<?php
class zzSql_Filter_ColorGroupFilter extends zzSql_Filter_Group{
    function __construct(zzSql_Source $source) {
        parent::__construct($source, $group, $index);
    }
}
