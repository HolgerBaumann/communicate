<?php namespace HolgerBaumann\SimpleContact\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHolgerBaumannSimpleContactContact extends Migration
{
    public function up()
    {
        Schema::table('holgerbaumann_simplecontact_contact', function($table)
        {
            $table->boolean('is_replied')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('holgerbaumann_simplecontact_contact', function($table)
        {
            $table->dropColumn('is_replied');
        });
    }
}
