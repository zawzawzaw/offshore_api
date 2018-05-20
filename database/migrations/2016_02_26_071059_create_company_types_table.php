<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('company_types', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('name');            
            $table->decimal('price', 10, 0);            
            $table->decimal('price_eu', 10, 0);            
            $table->string('rules');            
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
        //
        Schema::drop('company_types');
    }
}
