<?php

namespace Laralog\Laralog;

use Illuminate\Support\Collection;

class LogParser
{
    const LOG_SEPARATOR = '/(\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?\])/';
    const CONTEXT = '/[a-zA-Z]{1,12}\.[a-zA-Z]{1,12}:/m';
    const STACKTRACE = '/\[stacktrace\]/';


    public function formatLogsToCollection(string $logContents)
    {
        $logs = preg_split(self::LOG_SEPARATOR, $logContents, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $formattedLogs = new Collection;

        foreach ($logs as $key => $date) {
            if ($key % 2 == 0) {
                $log = $logs[$key+1];
                $date = str_replace(['[', ']'], '', $date);
                $logData = $this->logEntryToArray($date, $log);
                $formattedLogs->push($logData);
            }
        }

        return $formattedLogs;
    }

    public function formatLogsToJson(string $logContents)
    {
        return $this->formatLogsToCollection($logContents)->toJson();
    }

    private function logEntryToArray(string $date, string $logEntry)
    {
        $context = preg_match(self::CONTEXT, $logEntry, $matches);

        $contextString = $matches[0];

        $envAndLevel = explode('.', $contextString);

        $environment = isset($envAndLevel[0]) ? $envAndLevel[0] : "";

        $level = isset($envAndLevel[1]) ? str_replace(':', '', $envAndLevel[1]) : "";

        $message = preg_split("/{$contextString}/", $logEntry);
    
        $message = preg_split(self::STACKTRACE, $message[1]);

        $message = isset($message[0]) ? $message[0] : "";

        $stacktrace = preg_split(self::STACKTRACE, $logEntry);

        $stacktrace = isset($stacktrace[1]) ? $stacktrace[1] : "";

        return [
            'date' => $date,
            'environment' => $environment,
            'level' => $level,
            'message' => $message,
            'stacktrace' => $stacktrace
        ];
    }

    private function formatStacktrace(string $stackTrace)
    {
        //make stracktrace into an array
    }
}
