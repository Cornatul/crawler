<?php namespace UnixDevil\Crawler\Console;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use UnixDevil\Crawler\Clients\HtmlClient;
use UnixDevil\Crawler\DTO\HtmlStructureDTO;
use Winter\Storm\Console\Command;

class HtmlExtractor extends Command
{
    /**
     * @var string The console command name.
     */
    protected static $defaultName = 'crawler:html';

    /**
     * @var string The name and signature of this command.
     */
    protected $signature = 'crawler:html';

    /**
     * @var string The console command description.
     */
    protected $description = 'This will extract content from a html page using a json structure';

    /**
     * Execute the console command.
     * @param ClientInterface $client
     * @return void
     * @throws GuzzleException
     */
    final public function handle(ClientInterface $client): void
    {
        $this->output->success('Welcome!');

        $links = [
            'it' => 'https://www.cv-library.co.uk/it-jobs?perpage=100',
        ];

        $object = [
            'base_url' => 'https://www.cv-library.co.uk',
            "links" => $links,
            "iterator" => "h2.job__title > a",
            "fields"=> [
                "title" => "h1.job__title > span",
                "body" => "div.job__description",
                "url" => "",
                "category" => "",
                "image" => "img.job__logo",
            ],
        ];

        $links2 = [
            'it' => 'https://www.cwjobs.co.uk/jobs/analyst',
        ];

        $object2 = [
            'base_url' => 'https://www.cwjobs.co.uk',
            "links" => $links2,
            "iterator" => "a.resultlist-s1cl3t",
            "fields"=> [
                "title" => "div.title > h1",
                "body" => "div.job-description",
                "url" => "",
                "category" => "",
                "image" => "",
            ],
        ];

        $links3 = [
            'it' => 'https://www.reed.co.uk/jobs/it-jobs-in-london',
        ];

        $object3 = [
            'base_url' => 'https://www.reed.co.uk/',
            "links" => $links3,
            "iterator" => "h2.job-result-heading__title > a",
            "fields"=> [
                "title" => "header.job-header > div > h1",
                "body" => "div.description",
                "url" => "",
                "category" => "",
                "image" => "",
            ],
        ];

        $links4 = [
            'administration' => 'https://jobs.theguardian.com/jobs/administration/',
        ];

        $object4 = [
            'base_url' => 'https://jobs.theguardian.com',
            "links" => $links4,
            "iterator" => "a.js-clickable-area-link",
            "fields"=> [
                "title" => "h1.mds-font-trafalgar",
                "body" => "div.mds-tabs__panel__content",
                "url" => "",
                "category" => "",
                "image" => "img.logo",
            ],
        ];


        $links5 = [
            "cars" => "https://www.gumtree.com/cars/uk"
        ];

        $object4 = [
            'base_url' => 'https://www.gumtree.com',
            "links" => $links5,
            "iterator" => "a.listing-link",
            "fields"=> [
                "title" => "h1",
                "body" => "div.css-i2cx2f",
                "url" => "",
                "category" => "",
                "image" => "img.logo",
            ],
        ];
        $dto = HtmlStructureDTO::from($object4);
        $htmlClient = new HtmlClient($client, $dto);
        $htmlClient->process();
    }
}
