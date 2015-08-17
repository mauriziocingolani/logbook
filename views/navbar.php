<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;

/* @var $this mauriziocingolani\yii2fmwkphp\View */
?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<i class="fa fa-bookmark-o" style="font-size: 24px;"></i> LogBook',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $items = [
        ['label' => 'Home', 'url' => [Yii::$app->homeUrl], 'active' => $this->context->id == 'site' && $this->context->action->id == 'index'],
    ];
    if (Yii::$app->user->isGuest) :
        $items[] = ['label' => 'Login', 'url' => ['/login'], 'active' => $this->context->module->id == 'user' && $this->context->id == 'default' && $this->context->action->id == 'login'];
    else :
        $items[] = [
            'label' => 'Log',
            'active' => $this->context->id == 'log',
            'url' => Url::to(['/log']),
        ];
        $items[] = [
            'label' => '<!--<i class="fa fa-usd"></i>-->$Progetti',
            'active' => $this->context->id == 'projects',
            'url' => Url::to(['/progetti']),
            'visible' => Yii::$app->user->isDeveloper(),
        ];
        $userSubitems = [];
        $userSubitems[] = ['label' => 'Utente di classe <strong>' . Yii::$app->user->identity->role->Description . '</strong>'];
        $userSubitems[] = '<li class="divider"></li>';
        if (Yii::$app->user->isDeveloper()) :
            $userSubitems[] = ['label' => '<!--<i class="fa fa-at"></i>-->@ Utenti', 'url' => ['/utenti']];
            $userSubitems[] = '<li class="divider"></li>';
        endif;
//                $userSubitems[] = ['label' => '<i class="fa fa-info-circle"></i> Profilo', 'url' => ['#']];
//                $userSubitems[] = ['label' => '<i class="fa fa-list"></i> Ruoli', 'url' => ['/utenti/ruoli']];
        $userSubitems[] = ['label' => '<i class="fa fa-power-off"></i> Logout', 'url' => Url::to(['/logout'])];
        $items[] = [
            'label' => '<!--<i class="fa fa-at"></i>-->@ ' . Yii::$app->user->identity->Name,
            'items' => $userSubitems];
    endif;
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => $items,
    ]);
    NavBar::end();
    ?>

</div>