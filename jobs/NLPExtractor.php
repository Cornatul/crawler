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
use League\HTMLToMarkdown\HtmlConverter;
use UnixDevil\Crawler\Clients\NLPClient;
use UnixDevil\Crawler\Contracts\NLPContract;
use UnixDevil\Crawler\Contracts\SentimentContract;
use UnixDevil\Crawler\DTO\NLPArticleSentimentDTO;
use UnixDevil\Crawler\DTO\NlpDTO;
use UnixDevil\Crawler\Exceptions\NLPClientException;
use UnixDevil\Crawler\Exceptions\NLPException;
use UnixDevil\Crawler\Models\Article;
use UnixDevil\Crawler\Models\Feed;
use UnixDevil\Crawler\Models\FeedArticle;
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


    private NLPArticleSentimentDTO $dto;

    private Feed $feed;

    private int $tries;

    public function __construct(Feed $feed, string $url)
    {
//        $this->onQueue('nlp-extractor');
        $this->tries = 1;
        $this->dto = app(SentimentContract::class)->getArticleSentiment($url);
        $this->feed = $feed;
    }

    /**
     * Execute the job.
     */
    final public function handle(): void
    {
        $converter = new HtmlConverter();
        $converter->getConfig()->setOption('strip_tags', true);
        $converter->getConfig()->setOption('bold_style', '**');
        $converter->getConfig()->setOption('italic_style', '_');
        $converter->getConfig()->setOption('header_style', 'atx');
        $converter->getConfig()->setOption('suppress_errors', true);

        try {
            $postData = [
                'title' => $this->dto->title,
                'slug' => Str::slug($this->dto->title),
                'excerpt' => $this->dto->summary,
                'content' => ($this->dto->markdown),
                "content_html" => $converter->convert(
                    str_replace(
                        '<a href',
                        '<a rel="noopener noreferrer nofollow" target="_blank" href',
                        $this->dto->html
                    )
                ),
                "published_at" => Carbon::make($this->dto->date) ?? Carbon::now(),
                "published" => 1,
            ];

            if (str_word_count($this->dto->markdown) > 50) {
                $article = Article::create($postData);

                $feedArticle = FeedArticle::create([
                    'post_id' => $article->id,
                    'feed_id' => $this->feed->id,
                ]);
            }
        } catch (NLPClientException $exception) {
            info($exception->getMessage());
        }
    }

    final public function failed($exception = null): void
    {
        $this->delete();
    }



    final public function keywords(): array
    {
        return $this->dto->keywords;
    }

    private function createOrSelectCategory(string $name): int
    {
        return \Winter\Blog\Models\Category::firstOrCreate(['name' => $name])->id;
    }
}
