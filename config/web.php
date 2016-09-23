<?php

include '../vendor/mauriziocingolani/yii2-fmwk-php/Config.php';

use mauriziocingolani\yii2fmwkphp\Config;

$config = new Config(sha1('logbook-app'), dirname(__DIR__), 'files');
//$config->addCacheComponent();
$config->addAuthComponent([
    'twitter' => require 'files/auth_twitter.php',
    'linkedin' => require 'files/auth_linkedin.php',
    'facebook' => require 'files/auth_facebook.php',
]);
$config->addDbComponent();
//$config->addMailComponent();
$config->addSessionComponent(['timeout' => 14400]);
//$config->addTwitterComponent();
$config->addUserComponent();
$config->addI18NComponent();
$config->addUserModule([
    'canLoginWithSocial' => true,
]);
$config->language = 'it';
$config->name = 'LogBook';
$config->sourceLanguage = 'en';
$config->version = 'RC2';
if (YII_DEBUG)
    $config->enableGii(['82.85.62.218']);
//$config->addComponent([
//    'authClientCollection' => [
//        'class' => 'yii\authclient\Collection',
//        'clients' => [
//            'twitter' => require 'files/twitter_auth.php',
//        ],
//    ],
//]);
return $config->getConfig();
