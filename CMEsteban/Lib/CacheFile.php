<?php

namespace CMEsteban\Lib;

class CacheFile extends Cache
{
    public function __construct($path)
    {
        $this->path = $path;
    }

    public function write($index, $data)
    {
        $name = $this->getFilename($index);

        return (file_put_contents($name, $data) !== false);
    }

    protected function readData($name)
    {
        return file_get_contents($name);
    }
    public function getEntries() {
        return glob($this->getDir() . '/*');
    }
    protected function filemtime($file) {
        return filemtime($file);
    }

    protected function is_file($file) {
        return is_file($file);
    }
    protected function unlink($file) {
        return unlink($file);
    }
    public function getDir()
    {
        return $this->path;
    }
}
