<?php
namespace Riuson\EveApi\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCachesTable extends Migration
{

    public function up()
    {
        Schema::create('riuson_eveapi_caches', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('method');
            $table->text('params');
            $table->text('uri');
            $table->datetime('cached');
            $table->datetime('cachedUntil');
            $table->longtext('result');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riuson_eveapi_caches');
    }
}
