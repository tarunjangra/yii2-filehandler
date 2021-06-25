<?php
namespace yii\FileSystem;

use Exception;
use TJangra\FileHandler\Adapter\LocalAdapter;
use TJangra\FileHandler\AdapterInterface;
use TJangra\FileHandler\FileProcessor;
use yii\base\BaseObject;

class Handler extends BaseObject
{

    private array $matrix = [];
    private string $driver = 'gd';

    private AdapterInterface $adapter;
    private FileProcessor $processor;

    public function init()
    {
        parent::init();
        // validations
        if(!$this->adapter instanceof AdapterInterface) {
            throw new \Exception('Invalid adapter passed.');
        }
        if(!in_array($this->driver, ['gd','imagick'])) {
            throw new \Exception('Invalid image processing drivers. File handler supports gd and imagick');
        }
        $this->processor = new FileProcessor($this->matrix, $this->adapter, $this->driver);
    }

    public function setMatrix(array $matrix): void 
    {
        $this->matrix = $matrix;
    }


    public function setDriver(string $driver): void
    {
        $this->driver = $driver;
    }

    public function setAdapter(AdapterInterface $adapter): void
    {
        $this->adapter = $adapter;
    }

}