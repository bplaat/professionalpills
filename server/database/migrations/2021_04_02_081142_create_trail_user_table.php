<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrailUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trail_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trail_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('enrolled');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique([ 'trail_id', 'user_id' ]);

            $table->foreign('trail_id')
                ->references('id')
                ->on('trails')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trail_user');
    }
}
