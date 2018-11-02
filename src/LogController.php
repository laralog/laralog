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

        $log = file_get_contents($this->getLogDirectory() . $logBasename);

        $logEntries = $logParser->formatLogsToCollection($log);

        return response()->json([
            'log_entries' => $logEntries
        ]);
    }

    private function getLogDirectory()
    {
        return config('laralog.directory', storage_path() . '/logs/');
    }
}
