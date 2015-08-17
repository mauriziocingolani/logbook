<?php

include '../vendor/mauriziocingolani/yii2-fmwk-php/Config.php';

use mauriziocingolani\yii2fmwkphp\Config;

$config = new Config(sha1('logbook-app'), dirname(__DIR__), 'files');
//$config->addCacheComponent();
$config->addDbComponent();
//$config->addMailComponent();
$config->addSessionComponent(['timeout' => 14400]);
//$config->addTwitterComponent();
$config->addUserComponent();
$config->addI18NComponent();
$config->addUserModule();
$config->language = 'it';
$config->sourceLanguage = 'en';
$config->version = 'RC2';
if (YII_DEBUG)
    $config->enableGii(['82.85.62.218']);
return $config->getConfig();
