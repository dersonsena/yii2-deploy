<?php

namespace dersonsena\deploy;

use Yii;
use RuntimeException;
use yii\base\Module;

class DeployModule extends Module
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var bool
     */
    public $forceExecuteCommands = false;

    public function init()
    {
        $token = Yii::$app->getRequest()->get('t');
        $this->layout = 'deploy';

        if (!function_exists('shell_exec'))
            throw new RuntimeException('A função nativa do PHP "shell_exec" não está ativa no seu servidor WEB.');

        if (is_null($token))
            throw new RuntimeException('Requisição inválida! Token não foi informado!');

        if ($token !== $this->token)
            throw new RuntimeException('Requisição Inválida! Token informado é inválido!');

        parent::init();
    }
}
