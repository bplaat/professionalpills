<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospital_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('role');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique([ 'hospital_id', 'user_id' ]);

            $table->foreign('hospital_id')
                ->references('id')
                ->on('hospitals')
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
        Schema::dropIfExists('hospital_user');
    }
}
