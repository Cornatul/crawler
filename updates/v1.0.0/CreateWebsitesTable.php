<?php
declare(strict_types=1);

namespace UnixDevel\Feeds\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

/**
 * @class CreateWebsitesTable
 */
class CreateWebsitesTable extends Migration
{
    public function up(): void
    {

        Schema::create('unixdevil_websites', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unixdevil_websites');
    }

}
