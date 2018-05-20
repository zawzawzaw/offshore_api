<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanySecretaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('company_secretaries', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('company_id')->unsigned();            
            $table->string('name');
            $table->string('address');            
            $table->string('address_2');
            $table->string('address_3');     
            $table->foreign('company_id')->references('id')->on('companies');       
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
        Schema::drop('company_secretaries');
    }
}
