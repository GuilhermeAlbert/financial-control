<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extracts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('previous_balance');
            $table->decimal('current_balance');

            $table->unsignedBigInteger('source_account_id')->nullable();
            $table->foreign('source_account_id')->references('id')->on('accounts');

            $table->unsignedBigInteger('destination_account_id')->nullable();
            $table->foreign('destination_account_id')->references('id')->on('accounts');

            $table->foreignId('transaction_id')->constrained();
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
        Schema::dropIfExists('extracts');
    }
}
