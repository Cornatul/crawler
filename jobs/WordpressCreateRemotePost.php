<?php namespace UnixDevil\Crawler\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use UnixDevil\Crawler\Models\Website;

use Winter\Blog\Models\Post;

class WordpressCreateRemotePost implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Website $website;

    private Client $client;

    private Post $post;

    /**
     * Create a new job instance.
     */
    public function __construct(Website $website, Post $post)
    {
//        $this->queue = "default";
        $this->website = $website;
        $this->post = $post;
    }
    /**
     * Execute the job.
     * @todo add support for categories
     * @todo add support for tags
     * @todo add support for featured image
     * @todo add support for custom fields
     * @todo add support for custom post types
     * @todo add support for custom taxonomies
     */
    final public function handle(): void
    {

        $this->client = new Client([
            'base_uri' => $this->website->url,
            'timeout' => 2.0,
        ]);

        try {
            $this->createPost();

            $this->createOrSelectCategory("News");
        } catch (GuzzleException|\JsonException $e) {
            info($e->getMessage());
        }
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    private function createOrSelectCategory(string $category): void
    {
        $response = $this->client->request('POST', $this->website->url . '/wp-json/wp/v2/categories', [
            'auth' => [$this->website->username, $this->website->password],
            'json' => [
                'name' => $category,
            ],
        ]);

        $response = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        info(json_encode($response, JSON_THROW_ON_ERROR));

        info("createOrSelectCategory: " . $category);
    }


    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    private function createOrSelectTag(string $tag): void
    {
        $response = $this->client->request('POST', $this->website->url . '/wp-json/wp/v2/tags', [
            'auth' => [$this->website->username, $this->website->password],
            'json' => [
                'name' => $tag,
            ],
        ]);

        $response = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        info(json_encode($response, JSON_THROW_ON_ERROR));

        info("createOrSelectTags: " . $tag);
    }

    /**
     * @return void
     *@throws GuzzleException|\JsonException
     */
    private function createPost(): void
    {
        $response = $this->client->request('POST', $this->website->url . '/wp-json/wp/v2/posts', [
            'auth' => [$this->website->username, $this->website->password],
            'json' => [
                'title' => $this->post->title,
                'content' => $this->post->content,
                'status' => 'publish',
                'categories' => [1],
                'tags' => [1],
                'format' => 'standard',
                'author' => 1,
                'excerpt' => $this->post->excerpt,
            ],
        ]);
        $response = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        info("Create post");
        info(json_encode($response));
    }
}
