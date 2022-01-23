<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_user', function (Blueprint $table) {
            $table->foreignId('owner_id')
                    ->cascadeOnDelete()
                    ->constrained();

            $table->foreignId('user_id')
                    ->cascadeOnDelete()
                    ->constrained();

            $table->primary(['owner_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owner_user');
    }
}
