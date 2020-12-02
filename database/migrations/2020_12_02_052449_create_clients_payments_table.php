<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('projects_name_id');
            $table->bigInteger('clients_name_id')->nullable();
            $table->Double('payment_bdt',10,2);
            $table->Double('payment_usd',10,2)->nullable();
            $table->Double('payment_jpy',10,2)->nullable();
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
        Schema::dropIfExists('clients_payments');
    }
}
