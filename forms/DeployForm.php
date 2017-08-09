<?php
namespace dersonsena\deploy\forms;

use yii\base\Model;

class DeployForm extends Model
{
    /**
     * @var string
     */
    public $branch;

    /**
     * @var bool
     */
    public $enableComposer;

    /**
     * @var bool
     */
    public $forceExecuteCommands;

    /**
     * @var bool
     */
    public $installComposerAssetPlugin;

    /**
     * @var string
     */
    public $phpBin;

    /**
     * @var string
     */
    public $composerBin;

    /**
     * @var string
     */
    public $gitBin;

    /**
     * @var string
     */
    public $composerHome;

    /**
     * @var array
     */
    private $commands = [];

    /**
     * @var string
     */
    private $execText = '';

    public function init()
    {
        $module = \Yii::$app->controller->module;

        $this->attributes = [
            'branch' => $module->branch,
            'enableComposer' => $module->enableComposer,
            'forceExecuteCommands' => $module->forceExecuteCommands,
            'installComposerAssetPlugin' => $module->installComposerAssetPlugin,
            'phpBin' => $module->phpBin,
            'composerBin' => $module->composerBin,
            'gitBin' => $module->gitBin,
            'composerHome' => $module->composerHome,
        ];
    }

    public function rules()
    {
        return [
            [['branch', 'enableComposer', 'forceExecuteCommands', 'phpBin', 'composerBin', 'gitBin', 'composerHome'], 'required'],
            [['branch', 'phpBin', 'composerBin', 'gitBin', 'composerHome'], 'string'],
            [['enableComposer', 'forceExecuteCommands', 'installComposerAssetPlugin'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'branch' => 'Branch',
            'enableComposer' => "Executar o comando `composer update`.",
            'forceExecuteCommands' => "Forçar a execução dos comandos no ambiente de Desenvolvimento.",
            'installComposerAssetPlugin' => "Instalar pacote `fxp/composer-asset-plugin`.",
            'phpBin' => 'Binário do PHP',
            'composerBin' => 'Binário do Composer',
            'gitBin' => 'Binário do GIT',
            'composerHome' => 'Diretório do composer',
        ];
    }

    public function deploy()
    {
        if (YII_ENV_PROD)
            $this->forceExecuteCommands = true;

        $path = \Yii::getAlias('@app');

        $this->commands = [
            "cd {$path}",
            "{$this->gitBin} checkout -f 2>&1",
            "{$this->gitBin} pull origin {$this->branch} 2>&1"
        ];

        $this->addComposerAssetPlugin();
        $this->addComposerCommands();
        $this->executeCommands();
    }

    private function executeCommands()
    {
        if (YII_ENV_DEV && !$this->forceExecuteCommands) {
            $this->execText .= '[INFO] Ambiente de desenvolvimento não faz execução dos comandos. =)';
            return;
        }

        foreach ($this->commands as $command) {
            $this->execText .= "<strong>>> " . $command . "</strong>" . PHP_EOL;
            $this->execText .= shell_exec($command) . PHP_EOL;
            $this->execText .= '-----------------------------------' . PHP_EOL;
        }

        $this->registerLog();
    }

    private function addComposerCommands()
    {
        if (!$this->enableComposer)
            return;

        $path = \Yii::getAlias('@app');
        $composerLockFile = \Yii::getAlias('@app/composer.lock');
        $composerHome = (!is_null($this->composerHome) && !empty($this->composerHome) ? " COMPOSER_HOME=\"{$this->composerHome}\"" : '');

        if (!file_exists($composerLockFile))
            $this->commands[] = "cd {$path} &&{$composerHome} {$this->phpBin} {$this->composerBin} install 2>&1";
        else
            $this->commands[] = "cd {$path} &&{$composerHome} {$this->phpBin} {$this->composerBin} update 2>&1";
    }

    private function addComposerAssetPlugin()
    {
        if (!$this->installComposerAssetPlugin)
            return;

        $this->commands[] = "{$this->phpBin} {$this->composerBin} global require \"fxp/composer-asset-plugin:^1.3.1\" 2>&1";
    }

    private function registerLog()
    {
        $logPath = \Yii::getAlias('@runtime/deploy');

        if (!is_dir($logPath))
            mkdir($logPath, 0777, true);

        $filename = "deploy-" . date('YmdHis') . '.txt';
        $logText = "Date/Time: ". date('Y-m-d H:i:s') . PHP_EOL;
        $logText .= $this->execText;

        $handle = fopen($logPath . DS . $filename, 'a+');
        fwrite($handle, $logText);
        fclose($handle);
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * @return string
     */
    public function getExecText(): string
    {
        return $this->execText;
    }
}