<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->integer('role_id')->default(1);
            $table->integer('active')->default(1);
            $table->string('ip_address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('admin_users')->insert([
            [
                'id'=> 1,
                'name' => 'Developer Name',
                'email' => 'developer@saperemarketing.com',
                'password' => bcrypt('awesome'),
                'photo' => '',
                'role_id' => 1,
                'active' => 1,
                'ip_address' => '112.211.205.32',
                'created_at' => new \Carbon\Carbon,
                'updated_at' => new \Carbon\Carbon
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
