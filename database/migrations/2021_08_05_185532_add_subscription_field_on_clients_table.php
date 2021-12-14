<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionFieldOnClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('subscription')->nullable()->after('status');
            $table->integer('storage')->nullable()->after('subscription');
            $table->integer('storage_used')->nullable()->after('storage')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('subscription');
            $table->dropColumn('storage');
            $table->dropColumn('storage_used');
        });
    }
}
