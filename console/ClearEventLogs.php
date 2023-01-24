<?php namespace UnixDevil\Crawler\Console;

use System\Models\EventLog;
use Winter\Storm\Console\Command;

class ClearEventLogs extends Command
{
    /**
     * @var string The console command name.
     */
    protected static $defaultName = 'crawler:clear';

    /**
     * @var string The name and signature of this command.
     */
    protected $signature = 'crawler:clear';

    /**
     * @var string The console command description.
     */
    protected $description = 'Clears the event logs';

    /**
     * Execute the console command.
     * @return void
     */
    final public function handle(): void
    {
        $this->output->warning('Started cleaning the logs!');
        EventLog::truncate();
        $this->output->success('Finished!');
    }

}
