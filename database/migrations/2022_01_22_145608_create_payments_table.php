<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->string('id');
            $table->foreignId('charging_session_id')
                    ->nullable()
                    ->restrictOnDelete()
                    ->constrained();
            $table->string('payment_method');
            $table->string('status')->default('INITIATED');
            $table->string('payerAlias')->nullable();
            $table->string('payeeAlias')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('amount', 6, 2)->nullable();
            $table->string('clientip', 39);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ongoing_payments');
    }
}
