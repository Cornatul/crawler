<?php namespace UnixDevil\Crawler\Jobs;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use UnixDevil\Crawler\Clients\NLPClient;
use UnixDevil\Crawler\Contracts\NLPContract;
use UnixDevil\Crawler\DTO\NLPArticleSentimentDTO;
use UnixDevil\Crawler\DTO\NlpDTO;
use UnixDevil\Crawler\Exceptions\NLPClientException;
use UnixDevil\Crawler\Exceptions\NLPException;
use UnixDevil\Crawler\Models\LocalPost;
use Winter\Blog\Models\Post;
use Winter\Storm\Network\Http;
use Winter\Storm\Support\Str;

/**
 *
 */
class NLPExtractor implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $url;

    private NLPArticleSentimentDTO $dto;

    public function __construct(string $url)
    {
        $this->queue = 'nlp-extractor';
        $this->tries = 1;
        $this->url = $url;
        $this->dto = app(NLPContract::class)->getArticleSentiment($this->url);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $postData = [
                'title' => $this->dto->title,
                'slug' => Str::slug($this->dto->title),
                'excerpt' => $this->dto->summary,
                'content' => $this->dto->text,
                "content_html" => $this->dto->html,
                "published_at" => Carbon::make($this->dto->date) ?? Carbon::now(),
                "published" => 1,
            ];

            if (str_word_count($this->dto->text) > 500) {
                LocalPost::create($postData);
            }
        } catch (NLPClientException $exception) {
            info($exception->getMessage());
        }
    }

    public function failed($exception = null): void
    {
        $this->delete();
    }



    public function keywords(): array
    {
        return $this->dto->keywords;
    }

    private function createOrSelectCategory(string $name): int
    {
        return \Winter\Blog\Models\Category::firstOrCreate(['name' => $name])->id;
    }
}
