<?php

namespace dersonsena\deploy\controllers;

use dersonsena\deploy\forms\DeployForm;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $form = new DeployForm;
        $form->deploy();

        echo "<pre>{$form->getExecText()}</pre>";
    }
}
