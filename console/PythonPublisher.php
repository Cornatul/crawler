<?php namespace UnixDevil\Crawler\Console;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use UnixDevil\Crawler\Clients\HtmlClient;
use UnixDevil\Crawler\DTO\HtmlStructureDTO;
use UnixDevil\Crawler\Jobs\PublishPython;
use Winter\Storm\Console\Command;

class PythonPublisher extends Command
{
    /**
     * @var string The console command name.
     */
    protected static $defaultName = 'crawler:publish';

    /**
     * @var string The name and signature of this command.
     */
    protected $signature = 'crawler:publish';

    /**
     * @var string The console command description.
     */
    protected $description = 'This will publish a message to a queue for a python script to process';

    /**
     * Execute the console command.
     * @param ClientInterface $client
     * @return void
     * @throws GuzzleException
     */
    final public function handle(ClientInterface $client): void
    {
        $this->output->success('Welcome!');
        dispatch(new PublishPython("Some data"))->onQueue("python");
    }
}
