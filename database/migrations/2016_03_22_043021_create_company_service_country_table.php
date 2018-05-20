<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyServiceCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('company_service_country', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('service_country_id')->unsigned();        
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('service_country_id')->references('id')->on('service_country');
            $table->integer('credit_card_count');
            $table->timestamps('created_at');
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
        Schema::drop('company_service_country');
    }
}