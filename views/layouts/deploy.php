<?php
/* @var $this \yii\web\View */
/* @var $content string */

use dersonsena\deploy\assets\DeployAsset;
use yii\helpers\Html;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

DeployAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container">
    <div class="page-header">
        <h1>Yii2 Deploy <small>Simple App Deployer</small></h1>
    </div>

    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                <li><?= Html::a('<i class="glyphicon glyphicon-list-alt"></i> Deploy Manual', ['index', 't' => $this->context->module->token]) ?></li>
                <li><?= Html::a('<i class="glyphicon glyphicon-time"></i> Log de Deploy', ['log', 't' => $this->context->module->token]) ?></li>
            </ul>
        </div>
        <div class="col-md-10">
            <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12"><hr /></div>
        </div>
        <p class="pull-left">&copy; Yii2 Deploy Module <?= date('Y') ?></p>
        <p class="pull-right">
            <?= Html::a('by Kilderson Sena', 'https://github.com/dersonsena', [
                'title' => 'Meu perfil do GitHub',
                'target' => '_blank'
            ]) ?>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>