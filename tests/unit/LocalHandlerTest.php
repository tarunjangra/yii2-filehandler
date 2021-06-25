<?php
namespace yiiunit\FileSystem;

use TJangra\FileHandler\Adapter\LocalAdapter;
use Yii;
use yii\FileSystem\Handler;

class LocalHandlerTest extends \Codeception\Test\Unit
{
    use \Codeception\AssertThrows;

    protected function _before(): void
    {
        // Yii::$app->get('fh')->adapter = new LocalAdapter(yii::getAlias('@bucket'));
        Yii::$app->set('fh',[
            'class' => Handler::class,
            'matrix' => [
                'profile' => [
                    ['width' => 100, 'height' => 100],
                    ['width' => 50, 'height' => 50],
                    ['width' => 16, 'height' => 16],
                    ['width' => 200, 'height' => 200],
                ],
                'degree' => [
                    ['width' => 100, 'height' => 100],
                    ['width' => 600, 'height' => 600],
                ],
            ],
            'driver' => 'imagick',
            'adapter' => new LocalAdapter(yii::getAlias('@bucket')),
        ]);
        parent::_before();
    }
    
}
