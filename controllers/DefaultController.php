<?php

namespace dersonsena\deploy\controllers;

use Yii;
use yii\web\Controller;

/**
 * Default controller for the `deploy` module
 */
class DefaultController extends Controller
{
    /**
     * @var string
     */
    private $execText = '';

    /**
     * @var array
     */
    private $commands = [];

    public function actionIndex()
    {
        $path = Yii::getAlias('@app');

        $this->commands = [
            "cd {$path}",
            "git checkout -f 2>&1",
            "git pull origin {$this->module->branch} 2>&1"
        ];

        if (YII_ENV_DEV) {

            if ($this->module->forceExecuteCommands)
                $this->executeCommands();
            else
                $this->execText .= '[INFO] Ambiente de desenvolvimento não faz execução dos comandos. =)';

        } else {
            $this->executeCommands();
        }

        return $this->render('index', [
            'commands' => $this->commands,
            'output' => $this->execText
        ]);
    }

    private function executeCommands()
    {
        foreach ($this->commands as $command)
            $this->execText .= shell_exec($command) . PHP_EOL;

        $this->registerLog();
    }

    private function registerLog()
    {
        $logPath = Yii::getAlias('@runtime/deploy');

        if (!is_dir($logPath))
            mkdir($logPath, 0777, true);

        $filename = "deploy-" . date('YmdHis') . '.txt';
        $logText = "Date/Time: ". date('Y-m-d H:i:s') . PHP_EOL;
        $logText .= $this->execText;

        $handle = fopen($logPath . DS . $filename, 'a+');
        fwrite($handle, $logText);
        fclose($handle);
    }
}
