<?php
/* @var $this yii\web\View */
/* @var \dersonsena\deploy\forms\DeployForm $formModel */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Manual - Yii2 Deploy';
?>

<div class="deploy-default-index">
    <?php $form = ActiveForm::begin() ?>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($formModel, 'branch') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($formModel, 'composerHome') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($formModel, 'phpBin') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($formModel, 'composerBin') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($formModel, 'gitBin') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($formModel, 'enableComposer')->checkbox() ?>
            </div>
        </div>
        <?php if (YII_ENV_DEV): ?>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($formModel, 'forceExecuteCommands')->checkbox() ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <?= Html::submitButton('<i class="glyphicon glyphicon-ok-sign"></i> Fazer Deploy!', [
                    'class' => 'btn btn-primary btn-lg'
                ]) ?>
            </div>
        </div>
    <?php ActiveForm::end() ?>

    <?php if (!empty($formModel->getCommands())) : ?>
        <div class="row">
            <div class="col-md-12"><hr></div>
        </div>

        <h3>Comandos Executados</h3>
        <?php $i = 1 ?>
        <?php foreach ($formModel->getCommands() as $command) : ?>
            <p><pre><?= $command ?></pre></p>
            <?php $i++ ?>
        <?php endforeach; ?>

        <h3>Saída(s) do(s) Comando(s)</h3>
        <p><pre><?= $formModel->getExecText() ?></pre></p>
    <?php endif; ?>
</div>