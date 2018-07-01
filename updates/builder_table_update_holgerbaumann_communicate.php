<?php namespace HolgerBaumann\Communicate\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHolgerBaumannCommunicate extends Migration
{
    public function up()
    {
        Schema::table('holgerbaumann_communicate', function($table)
        {
            $table->boolean('is_replied')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('holgerbaumann_communicate', function($table)
        {
            $table->dropColumn('is_replied');
        });
    }
}
