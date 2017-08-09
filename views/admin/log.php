<?php
/* @var yii\web\View $this  */
/* @var array $files */
/* @var string $token */
/* @var string $file */
/* @var string $fileContent */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Log - Yii2 Deploy';
?>

<div class="deploy-default-index">
    <h3>Log de Execuções</h3>

    <ul>
    <?php foreach ($names as $i => $name) : ?>
        <li>
            <?= Html::a($name, ['log', 't' => $token, 'f' => $name], [
                'title' => 'Ver conteúdo do arquivo de log'
            ]) ?>
        </li>
    <?php endforeach; ?>
    </ul>

    <?php if (!empty($fileContent)) : ?>
        <div class="row">
            <div class="col-md-12"><hr></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p>Arquivo: <strong><?= $file ?></strong></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <pre><?= $fileContent ?></pre>
            </div>
        </div>
    <?php endif; ?>
</div>