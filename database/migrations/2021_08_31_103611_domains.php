<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Domains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('domain_name')->nullable;
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('domain_type');
            $table->timestamps();

            // $table->foreign('domain_type')->references('id')->on('domain_types');
            // $table->foreign('user_id')->references('id')->on('users');


        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
