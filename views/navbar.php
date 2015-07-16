<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
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
//        $items[] = ['label' => 'Login', 'url' => ['/login'], 'active' => $this->context->module->id == 'user' && $this->context->id == 'default' && $this->context->action->id == 'login'];
    else :
        $items[] = [
            'label' => 'Estrazioni',
            'active' => $this->context->id == 'estrazioni',
            'items' => [
                ['label' => '<i class="fa fa-folder-open-o" style="width: 20px;"></i> Storico', 'url' => Url::to(['/estrazioni/storico'])],
                ['label' => '<i class="fa fa-plus-circle" style="width: 20px;"></i> Nuova', 'url' => Url::to(['/estrazioni/nuova'])],
                ['label' => '<i class="fa fa-cogs" style="width: 20px;"></i> Generazione Xlsx', 'url' => Url::to(['/estrazioni/generazione-xlsx'])],
            ]
        ];
        $userSubitems = [];
        if (Yii::$app->user->isDeveloper()) :
            $userSubitems[] = ['label' => '<i class="fa fa-group"></i> Utenti', 'url' => ['/utenti']];
            $userSubitems[] = '<li class="divider"></li>';
        endif;
//                $userSubitems[] = ['label' => '<i class="fa fa-info-circle"></i> Profilo', 'url' => ['#']];
//                $userSubitems[] = ['label' => '<i class="fa fa-list"></i> Ruoli', 'url' => ['/utenti/ruoli']];
        $userSubitems[] = ['label' => '<i class="fa fa-power-off"></i> Logout', 'url' => Url::to(['/logout'])];
        $items[] = [
            'label' => '<i class="fa fa-user"></i> ' . Yii::$app->user->identity->Name,
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