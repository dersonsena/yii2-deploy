<?php

namespace dersonsena\deploy\controllers;

use dersonsena\deploy\forms\DeployForm;
use Yii;
use yii\base\ErrorException;
use yii\web\Controller;
use yii\helpers\FileHelper;

class AdminController extends Controller
{
    public function actionIndex()
    {
        $form = new DeployForm;
        $post = Yii::$app->getRequest()->post();

        if ($form->load($post) && $form->validate())
            $form->deploy();

        return $this->render('index', [
            'formModel' => $form
        ]);
    }

    public function actionLog()
    {
        $names = [];
        $fileContent = '';
        $files = FileHelper::findFiles(Yii::getAlias('@runtime/deploy'), ['only' => ['*.txt']]);
        $file = Yii::$app->getRequest()->get('f');

        foreach ($files as $path) {
            $currentPath = explode('/', $path);
            $currentFileName = array_pop($currentPath);
            $names[] = $currentFileName;

            if (!is_null($file) && ($currentFileName === $file))
                $fileContent = file_get_contents($path);
        }

        return $this->render('log', [
            'names' => $names,
            'token' => $this->module->token,
            'file' => $file,
            'fileContent' => $fileContent
        ]);
    }
}