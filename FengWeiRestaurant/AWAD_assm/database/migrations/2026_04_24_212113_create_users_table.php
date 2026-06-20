<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 10)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('countryCode', 10)->nullable();
            $table->string('phoneNumber', 15)->nullable();
            $table->rememberToken();
        });
    }
 
    public function down()
    {
        Schema::dropIfExists('users');
    }
};