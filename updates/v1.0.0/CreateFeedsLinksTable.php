<?php
namespace UnixDevel\Feeds\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

/**
 */
class CreateFeedsLinksTable extends Migration
{
    public function up()
    {

        Schema::create('unixdevil_feed_links', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('feed_id')->unsigned();
            $table->string('url')->nullable();
            $table->datetime('crawled_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('unixdevil_feed_links');
    }

}
