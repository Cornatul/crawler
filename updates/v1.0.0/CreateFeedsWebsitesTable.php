<?php
namespace UnixDevel\Feeds\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

/**
 */
class CreateFeedsWebsitesTable extends Migration
{
    final public function up(): void
    {

        Schema::create('unixdevil_crawler_feed_websites', function ($table) {
            $table->engine = 'InnoDB';
            $table->integer('feed_id')->unsigned();
            $table->integer('website_id')->unsigned();
            $table->primary(['feed_id', 'website_id']);
        });
    }

    final public function down(): void
    {
        Schema::dropIfExists('unixdevil_crawler_feed_websites');
    }
}
