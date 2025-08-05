<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpportunitiesTable extends Migration
{
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('region')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->default('open');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('opportunities');
    }
}
