<?php
namespace UnixDevel\Crawler\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

/**
 * @class CreateFeedsTable
 */
class CreateFeedsTable extends Migration
{
    public function up():void
    {
        Schema::create('unixdevil_feeds', static function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('url')->nullable();
            $table->string('image')->nullable();
            $table->integer('score')->nullable();
            $table->timestamp('last_update')->nullable();
            $table->integer('subscribers')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('unixdevil_feeds');
    }

}
