<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server', function (Blueprint $table) {
            $table->id();
            $table->string('client_name',255)->nullable();
            $table->string('project_name',255)->nullable();
            $table->string('ip_address',255);
            $table->text('url');
            $table->string('user_name',255);
            $table->string('password',255);
            $table->string('port',255)->nullable();
            $table->string('db_link',255)->nullable();
            $table->string('db_user',255)->nullable();
            $table->string('db_password',255)->nullable();
            $table->text('note')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server');
    }
}
