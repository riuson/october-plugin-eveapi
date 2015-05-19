<?php
namespace Riuson\EveApi\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateFailureLogsTable extends Migration
{

    public function up()
    {
        Schema::create('riuson_eveapi_failure_logs', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('method');
            $table->text('params');
            $table->text('uri');
            $table->integer('errorCode');
            $table->string('errorText');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riuson_eveapi_failure_logs');
    }
}
