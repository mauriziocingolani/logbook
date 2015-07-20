<?php

use yii\helpers\Html;
?>

<p>Per accedere a LogBook clicca su questo link (o incollalo sul browser se non lo visualizzi correttamente):</p>
<p style="padding-left: 25px;">
<?= Html::a('http://logbook.mauriziocingolani.it/login'); ?>
</p>
<p>Queste sono le credenziali per il login:</p>
<dl style="background: lightblue;padding: 10px;">
    <dt>Utente:</dt>
    <dd style="font-weight: bold;"><?php echo $username; ?></dd>
    <dt>Password:</dt>
    <dd style="font-weight: bold;"><?php echo $password; ?></dd>
</dl>
<p>
    Questa mail &egrave; destinata a utenti di LogBook. Se hai ricevuto questa email 
    per errore sei pregato di ignorarne il contenuto e di eliminarla.
</p>