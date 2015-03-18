<?php namespace riuson\EveApi\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCacheTable extends Migration
{

    public function up()
    {
        Schema::dropIfExists('riuson_eveapi_cache');

        Schema::create('riuson_eveapi_cache', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->text('uri');
            $table->datetime('cached');
            $table->datetime('cachedUntil');
            $table->longtext('result');

            //$table->index('uri');
        });
    }

    public function down()
    {
        Schema::dropIfExists('riuson_eveapi_cache');
    }

}
