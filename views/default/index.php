<?php
/* @var $this yii\web\View */
/* @var $commands array */
/* @var $output string */
$this->title = 'Yii2 Deploy Module - by Kilderson Sena';
?>

<div class="deploy-default-index">
    <h1>Saída do Terminal</h1>

    <h3>Comandos Executados</h3>
    <?php foreach ($commands as $command) : ?>
        <p><pre><?= $command ?></pre></p>
    <?php endforeach; ?>

    <h3>Saída(s) do(s) Comando(s)</h3>
    <p><pre><?= $output ?></pre></p>
</div>
