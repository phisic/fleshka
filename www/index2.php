<?php
ini_set("error_reporting", E_ALL | E_STRICT | E_NOTICE);
ini_set("display_errors","1");
ini_set("max_execution_time","1");
set_time_limit(10);

function showtime($text = ''){
	static $start = 0;
	if ($start != 0){	
		echo "<br>$text ".(microtime(true)-$start);
	}//else
		$start = microtime(true);
}
function gettime(){
	static $start = 0;
        if ($start != 0){
		$ret = (microtime(true)-$start);
	}else
                $ret = 0;
		$start = microtime(true);
                
        return $ret;
}showtime();gettime();

define ('ZZCACHE_DIR', dirname(__FILE__).'/../../lizzi.lib/cache/');
//define ('FIRSTRUN_FILE', ZZCACHE_DIR.'first.run.tmp');
define ('ZZMYSQL_DEBUG', 0);
define ('ZZCACHE', 1);
//define ('ZZFILE_CHARSET', 'windows-1251');
//define ('ZZDEBUG', 1);
//zzdebugErrorHandler::$debugToFiles[] = '/';
define ('RELEASE', 1);

include(dirname(__FILE__).'/../../lizzi.lib/last/core.php');
//zzdebugErrorHandler::$debugToPrint = true;
zzdebugErrorHandler::$debugToEmails[] = 'liz2k.b8@gmail.com';
zzModules::addPath(dirname(__FILE__).'/../modules/');

if (zzClasses::create('zzControllerRouter_Dir')
    ->setDirectoryPath(dirname(__FILE__).'/../controllers/')
    ->ZZ('}')
    ->select(
        zzClasses::create('zzControllerRouter_Filter')
            ->setSourceUrl(
                zzClasses::create('zzControllerRouter_SourceUrl')
            )
    )->each('runController')
    ->countResult() == 0)
        zzNew('zzView')->set404();

echo zzNew('zzView');
//showtime();
