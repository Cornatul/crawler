<?php
namespace UnixDevel\Feeds\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

/**
 */
class CreateFeedsArticlesTable extends Migration
{
    final public function up(): void
    {

        Schema::create('unixdevil_crawler_feed_articles', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('feed_id')->unsigned();
            $table->integer('post_id')->unsigned();

        });
    }

    final public function down(): void
    {
        Schema::dropIfExists('unixdevil_crawler_feed_articles');
    }
}
