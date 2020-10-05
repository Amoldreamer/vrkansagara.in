<?php

namespace Blog\Compiler;

class ResponseFile
{
    protected $filename;

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function getFilename()
    {
        return $this->filename;
    }
}
