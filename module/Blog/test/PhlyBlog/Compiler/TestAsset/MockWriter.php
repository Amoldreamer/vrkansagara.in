<?php

namespace Blog\Compiler\TestAsset;

use Blog\Compiler\WriterInterface;

class MockWriter implements WriterInterface
{
    public $files = [];

    public function write($filename, $data)
    {
        $this->files[$filename] = $data;
    }
}
