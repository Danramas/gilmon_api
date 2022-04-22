<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 200)->unique();
            $table->jsonb('payload')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
