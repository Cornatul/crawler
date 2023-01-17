<?php namespace UnixDevil\Crawler\Console;

use Winter\Storm\Console\Command;

class CreatePost extends Command
{
    /**
     * @var string The console command name.
     */
    protected static $defaultName = 'crawler:create-post';

    /**
     * @var string The name and signature of this command.
     */
    protected $signature = "";

    /**
     * @var string The console command description.
     */
    protected $description = 'Create a post';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->output->writeln('Hello world!');
    }

    /**
     * Provide autocomplete suggestions for the "myCustomArgument" argument
     */
    // public function suggestMyCustomArgumentValues(): array
    // {
    //     return ['value', 'another'];
    // }
}
