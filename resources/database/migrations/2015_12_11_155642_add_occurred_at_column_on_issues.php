<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOccurredAtColumnOnIssues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issues', function(Blueprint $table)
        {
            $table->timestamp('occurred_at')->after('closed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('issues', function(Blueprint $table)
        {
            $table->dropColumn('occurred_at');
        });
    }
}
