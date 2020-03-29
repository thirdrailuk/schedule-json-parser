<?php

namespace TrainjunkiesPackages\NetworkRailScheduleFileParser;

class Parser
{
    /**
     * @var \SplFileObject
     */
    private $splFileObject;

    public function __construct(\SplFileObject $splFileObject)
    {
        $this->splFileObject = $splFileObject;
    }

    /**
     * @param callable $meta
     * @param callable $tiploc
     * @param callable $association
     * @param callable $schedule
     *
     * @return void
     */
    public function parse(
        callable $meta,
        callable $tiploc,
        callable $association,
        callable $schedule
    ) {
        foreach ($this->each() as $line) {
            $callbackName = $this->lineType($line);

            if (isset($$callbackName)) {
                $$callbackName($line);
            }
        }
    }

    /**
     * @param string $line
     *
     * @return string|null
     */
    private function lineType($line)
    {
        if (strpos($line, '{"JsonTimetableV1"') === 0) {
            return 'meta';
        }

        if (strpos($line, '{"TiplocV1"') === 0) {
            return 'tiploc';
        }

        if (strpos($line, '{"JsonAssociationV1"') === 0) {
            return 'association';
        }

        if (strpos($line, '{"JsonScheduleV1"') === 0) {
            return 'schedule';
        }

        return null;
    }

    private function each(): \Generator
    {
        while (!$this->splFileObject->eof()) {
            yield $this->splFileObject->fgets();
        }
    }
}
