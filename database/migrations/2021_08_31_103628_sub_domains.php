<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubDomains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_domains', function (Blueprint $table) {
            $table->id();
            $table->string('domain_name');
            $table->unsignedBigInteger('domain_type');
            $table->unsignedBigInteger('domain_id');
            $table->timestamps();


            // $table->foreign('domain_type')->references('id')->on('domain_types');
            // $table->foreign('domain_id')->references('id')->on('domains');
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
