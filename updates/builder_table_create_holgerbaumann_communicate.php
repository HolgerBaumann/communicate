<?php namespace HolgerBaumann\Communicate\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHolgerBaumannCommunicate extends Migration
{
    public function up()
    {
        Schema::create('holgerbaumann_communicate', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->boolean('is_new')->default(1);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('holgerbaumann_communicate');
    }
}
