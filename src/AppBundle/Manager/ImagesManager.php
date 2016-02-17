<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Images;
use Swarrot\Broker\Message;
use Swarrot\SwarrotBundle\Broker\Publisher;

class ImagesManager
{
    private $publisher;
    private $cachePath;
    private $rootPath;

    public function __construct(Publisher $publisher, $cachePath, $rootPath)
    {
        $this->publisher = $publisher;
        $this->cachePath = $cachePath;
        $this->rootPath = $rootPath;
    }

    public function save(Images $files)
    {
        $filenames = array();
        foreach ($files->getFiles() as $file) {
            $filename = uniqid().'.'.$file->getClientOriginalExtension();

            $file->move($this->tmpPath(), $filename);

            $message = new Message(json_encode([
                'filename' => $filename
            ]));
            $this->publisher->publish('images', $message);

            $filenames[] = $filename;
            $this->touch($filename);
        }

        return $filenames;
    }

    public function process($filename)
    {
        rename($this->tmpPath().DIRECTORY_SEPARATOR.$filename, $this->path($filename));
    }

    public function getAll()
    {
        $images = [];

        $d = dir($this->path());
        while (false !== ($filename = $d->read())) {
            if (in_array($filename, ['.', '..'])) {
                continue;
            }
            $images[] = $this->uri($filename);
        }

        return $images;
    }

    public function get($filename)
    {
        return $this->uri($filename);
    }

    private function touch($filename)
    {
        touch($this->path($filename));
    }

    private function path($filename = "")
    {
        $path = $this->rootPath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'web/images'.DIRECTORY_SEPARATOR;

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        return $path.$filename;
    }

    private function tmpPath($filename = "")
    {
        $tmpDir = $this->cachePath.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR;

        if (!file_exists($tmpDir)) {
            mkdir($tmpDir, 0777, true);
        }

        return $tmpDir.$filename;
    }

    private function uri($filename)
    {
        return '/images/'.$filename;
    }
}
