<?php
/* @var $this mauriziocingolani\yii2fmwkphp\View */

use mauriziocingolani\yii2fmwkrpsls\RpslsWidget;

require_once Yii::$app->basePath . '/vendor/mauriziocingolani/yii2-fmwk-rpsls/RpslsWidget.php';
?>

<h1>Coming Soon...</h1>

<h3>Cos'&egrave; LogBook</h3>
<p>
    <span class="lb-obj">LogBook</span> &egrave; un applicativo web per la condivisione di informazioni riguardanti i propri progetti.
    Sei stanco di condividere le informazioni e le scelte con il tuo gruppo di lavoro tramite le odiate email 
    con decine di persone in copia e uno storico di forward e reply lungo alcune pagine?
    Con <span class="lb-obj">LogBook</span> puoi fare in modo che tutte le informazioni, i commenti e le decisioni strategiche sul tuo progetto
    siano visibili a tutti, grazie a un semplice e immediato meccanismo di taggatura delle persone interessate e
    degli argomenti in ballo.
</p>

<h3>Come funziona</h3>
<p>
    Crea il tuo <span class="lb-obj"><i class="fa fa-usd"></i>progetto</span>, e inizia a popolare il suo diario
    con le voci riguardanti le informazioni, le richieste di chiarimento o di sviluppo che normalmente scambieresti
    via email con i colleghi del tuo team. Nomina le <span class="lb-obj"><i class="fa fa-at"></i>persone</span>
    coinvolte e gli <span class="lb-obj"><i class="fa fa-hashtag"></i>argomenti</span> in discussione. Una volta creato
    il diario potrai ricercare le voci che ti interessano in base alle persone e agli argomenti che sono nominati al
    loro interno, oppure semplicemente tramite il testo contenuto.
    In questo modo tutti potranno ritrovare rapidamente le voci che li riguardano, o che trattano gli argomenti che
    li coinvolgono, senza dover decifrare le informazioni contenute in decine e decine di email scambiate con i colleghi.
</p>

<hr />

Gioca a <a href="" data-toggle="modal" data-target="#rpsls-modal">Rock-Paper-Scissors-Lizard-Spock</a>

<?= RpslsWidget::widget(); ?>