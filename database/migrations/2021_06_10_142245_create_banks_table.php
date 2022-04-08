<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('owner', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('dni', 20)->nullable();
            $table->string('account_number', 30)->nullable();
            $table->enum('type', ['BS', 'USD'])->default('BS');
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
        Schema::dropIfExists('banks');
    }
}
