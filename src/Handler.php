<?php

namespace yii\FileSystem;

use Exception;
use TJangra\FileHandler\Adapter\LocalAdapter;
use TJangra\FileHandler\AdapterInterface;
use TJangra\FileHandler\FileProcessor;
use yii\base\BaseObject;

class Handler extends BaseObject
{

    private array $_matrix = [];
    private string $_driver = 'gd';

    private AdapterInterface $_adapter;
    private FileProcessor $_processor;
    private bool $_preserveOriginalFile = false;

    public function init()
    {
        parent::init();
        // validations
        if (!$this->_adapter instanceof AdapterInterface) {
            throw new \Exception('Invalid adapter passed.');
        }
        if (!in_array($this->_driver, ['gd', 'imagick'])) {
            throw new \Exception('Invalid image processing drivers. File handler supports gd and imagick');
        }
        
        $this->_processor = new FileProcessor($this->_matrix, $this->_adapter, $this->_preserveOriginalFile, $this->_driver);
    }

    public function setMatrix(array $matrix): void
    {
        $this->_matrix = $matrix;
    }

    public function getExtension(): string
    {
        return $this->_processor->getExtension();
    }

    public function getProcessor(): FileProcessor
    {
        return $this->_processor;
    }

    public function getFileName(): string
    {
        return $this->_processor->getFileName();
    }

    public function setDriver(string $driver): void
    {
        $this->_driver = $driver;
    }

    public function setAdapter(AdapterInterface $adapter): void
    {
        $this->_adapter = $adapter;
    }

    public function setPreserveOriginal(bool $preserve): void
    {
        $this->_preserveOriginalFile = $preserve;
    }
}
