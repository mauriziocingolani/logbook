<?php

use yii\helpers\Html;
?>

<p>La tua password dimenticata:</p>
<dl style="background: lightblue;padding: 10px;">
    <dt>Password:</dt>
    <dd style="font-weight: bold;"><?php echo $password; ?></dd>
</dl>

<p>Ti ricordiamo che per accedere a LogBook puoi cliccare su questo link (o incollarlo sul browser se non lo visualizzi correttamente):</p>
<p style="padding-left: 25px;">
    <?= Html::a('http://logbook.mauriziocingolani.it/login'); ?>
</p>
<p>e utilizzare il tuo nome utente:</p>
<dl style="background: lightblue;padding: 10px;">
    <dt>Utente:</dt>
    <dd style="font-weight: bold;"><?php echo $username; ?></dd>
</dl>
<p>Se vuoi puoi effettuare il login utilizzando il tuo indirizzo email al posto del nome utente.</p>
<p style="font-style: italic;">
    Questa mail &egrave; destinata a utenti di LogBook. Se hai ricevuto questa email 
    per errore sei pregato di ignorarne il contenuto e di eliminarla.
</p>