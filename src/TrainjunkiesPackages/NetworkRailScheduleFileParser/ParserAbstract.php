<?php

namespace TrainjunkiesPackages\NetworkRailScheduleFileParser;

abstract class ParserAbstract
{
    /**
     * @var \SplFileObject
     */
    private $fileObject;

    public function __construct(\SplFileObject $splFileObject)
    {
        $this->fileObject = $splFileObject;
    }

    public function each()
    {
        while (!$this->fileObject->eof()) {
            $line = $this->fileObject->fgets();

            if ($this->lineMatcher($line)) {
                yield ($line);
            }
        }
    }

    public function get(callable $function)
    {
        $this->readLine(function ($line) use ($function) {
            $function($line);
        });
    }

    protected function readLine(callable $function)
    {
        while (!$this->fileObject->eof()) {
            $line = $this->fileObject->fgets();

            if ($this->lineMatcher($line)) {
                $function($line);
            }
        }
    }

    protected function lineMatcher($line)
    {
        return strpos($line, $this->startsWith()) === 0;
    }
}
