<?php

namespace Laralog\Laralog;

use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Laralog\Laralog\LogParser;
use Illuminate\Foundation\Validation\ValidatesRequests;

class LogController extends Controller
{
    use ValidatesRequests;
    
    public function getAvailableLogs()
    {
        $pathToLogs = $this->getLogDirectory();

        $files = Collection::make(app('files')->files($pathToLogs));

        $files = $files->filter(function ($file) {
            return preg_match('/.log$/', basename($file));
        })->map(function ($file) {
            return [
                'size' => $file->getSize(),
                'basename' => basename($file)
            ];
        })
        ->values();

        return response()->json([
            'files' => $files
        ]);
    }

    public function getLog()
    {
        $data = $this->validate(request(), [
            'log_basename' => 'string|required'
        ]);

        $logBasename = $data['log_basename'];

        $logParser = new LogParser;

        $filePath = $this->getLogDirectory() . $logBasename;

        //check the file size, if the file is too big return an error
        //max is 30mb, this is probably still way too big,
        if ($logParser->isLogTooLarge($filePath)) {
            if (config('laralog.truncated_logs')) {
                $log = $logParser->truncatedLogContents($filePath);
                $logEntries = $logParser->formatLogsToCollection($log);

                return response()->json([
                    'log_entries' => $logEntries
                ]);
            }

            return response()->json([
                'error' => 'File size is too big.'
            ], 422);
        }

      
        $log = file_get_contents($this->getLogDirectory() . $logBasename);

        $logEntries = $logParser->formatLogsToCollection($log);

        return response()->json([
            'log_entries' => $logEntries
        ]);
    }

    public function splitLog()
    {
        //split log based
    }

    private function getLogDirectory()
    {
        return config('laralog.directory', storage_path() . '/logs/');
    }
}
