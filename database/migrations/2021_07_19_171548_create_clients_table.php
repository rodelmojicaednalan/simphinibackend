<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_email')->nullable();
            $table->string('company_address')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('person_in_charge');
            $table->string('payment_method')->nullable();
            $table->string('status');
            $table->string('db_host');
            $table->string('db_username');
            $table->string('db_password');
            $table->string('db_name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
