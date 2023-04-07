<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->bigInteger("advertId");
            $table->string("name")->nullable();
            $table->integer("type"); 
            $table->integer("status");
            $table->integer("dailyBudget");
            $table->string("createTime");
            $table->string("changeTime");
            $table->string("startTime");
            $table->string("endTime");
            $table->integer("begin")->nullable();
            $table->integer("end")->nullable();
            $table->integer("price");
            $table->integer("subjectId");
            $table->string("subjectName");
            $table->bigInteger("nmId");
            $table->boolean("isActive");
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
        Schema::dropIfExists('adverts');
    }
};
