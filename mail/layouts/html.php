<?php

use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
        <style type="text/css">

        </style>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <?= $content ?>

        <hr />
        <img src="http://logbook.mauriziocingolani.it/img/logo.png" alt="logo_logbook" />
        <span style="font-family: PT Sans Narrow;font-size: 18px;">LogBook</span>
        <p>
            &copy;2015 - <?= Html::a('Maurizio Cingolani', 'http://www.mauriziocingolani.it'); ?>
        </p>
        <div style="font-size: small;font-style: italic;">
            <p><strong>Informativa sulla privacy (D.LGS 196/2003)</strong></p>
            
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>