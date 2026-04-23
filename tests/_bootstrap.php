<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../../yii/framework/yii.php';
$component=dirname(__FILE__).'/../protected/components';
$config=dirname(__FILE__).'/../protected/config/main.php';
$controllers=dirname(__FILE__).'/../protected/controllers';
$models=dirname(__FILE__).'/../protected/models';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);



require_once($config);
require_once($yii);
//Yii::createWebApplication($config)->run();

function include_all_php($folder){
    foreach (glob("{$folder}/*.php") as $filename)
    {
        include $filename;
    }
}
include_all_php($component);
include_all_php($controllers);
include_all_php($models);
