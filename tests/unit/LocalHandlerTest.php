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

    public function testSave() 
    {
        \Yii::$app->fh->save(\Yii::getAlias('@data').'/test.jpg','profile','798789wuewio');
        $this->assertTrue(file_exists(Yii::getAlias('@bucket').'/798789wuewio/profile/16x16.jpg'));
        $this->assertTrue(file_exists(Yii::getAlias('@bucket').'/798789wuewio/profile/50x50.jpg'));
        $this->assertTrue(file_exists(Yii::getAlias('@bucket').'/798789wuewio/profile/100x100.jpg'));
        $this->assertTrue(file_exists(Yii::getAlias('@bucket').'/798789wuewio/profile/200x200.jpg'));
    }
    public function testRead()
    {   
        $fileData = \Yii::$app->fh->read('798789wuewio/profile/16x16.jpg');
        $this->assertTrue($fileData === file_get_contents(Yii::getAlias('@bucket').'/798789wuewio/profile/16x16.jpg'));
    }
    public function testDelete()
    {   
        \Yii::$app->fh->delete('798789wuewio/profile/16x16.jpg');
        $this->assertFalse(file_exists(Yii::getAlias('@bucket').'/798789wuewio/profile/16x16.jpg'));
        $this->assertTrue(file_exists(Yii::getAlias('@bucket').'/798789wuewio/profile/50x50.jpg'));
        $this->assertTrue(file_exists(Yii::getAlias('@bucket').'/798789wuewio/profile/100x100.jpg'));
        $this->assertTrue(file_exists(Yii::getAlias('@bucket').'/798789wuewio/profile/200x200.jpg'));
    }

    public function testDeleteDirectory()
    {   
        \Yii::$app->fh->deleteDirectory('798789wuewio/profile');
        $this->assertFalse(file_exists(Yii::getAlias('@bucket').'/798789wuewio/profile/16x16.jpg'));
        $this->assertFalse(file_exists(Yii::getAlias('@bucket').'/798789wuewio/profile/50x50.jpg'));
        $this->assertFalse(file_exists(Yii::getAlias('@bucket').'/798789wuewio/profile/100x100.jpg'));
        $this->assertFalse(file_exists(Yii::getAlias('@bucket').'/798789wuewio/profile/200x200.jpg'));
    }
    
}
