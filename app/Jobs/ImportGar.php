<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use XMLReader;

class ImportGar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 60 * 60;
    public int $tries = 1;

    public function __construct(
        public string $fileName,
        public string $nodeName,
        public string $serviceName
    )
    {
    }

    public function handle(): void
    {
        if (Storage::fileExists($this->fileName)) {
            $this->xmlParse();
        }
    }

    private function xmlParse(): void
    {
        $xml = new XMLReader();
        if ($xml->open(Storage::path($this->fileName))) $this->readXml($xml);
    }

    private function readXml(XMLReader $xml): void
    {
        $serviceName = new $this->serviceName;
        while ($xml->read() && $xml->name !== $this->nodeName) ;
        while ($xml->name === $this->nodeName) {
            if ($xml->hasAttributes) {
                $node = (array)simplexml_load_string($xml->readOuterXml());
                $node = $node['@attributes'];
                $serviceName->addLine($node);
            }
            $xml->next($this->nodeName);
        }
        $this->deleteProcessedFile();
    }

    private function deleteProcessedFile(): void
    {
        Storage::delete($this->fileName);
    }

}
