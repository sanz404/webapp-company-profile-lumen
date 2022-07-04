<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('country_id')->nullable()->index();
            $table->string('username', 64)->unique();
            $table->string('email', 64)->unique();
            $table->string('phone')->unique()->nullable();
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->string('city')->unique()->nullable();
            $table->string('zip_code', 64)->nullable()->index();
            $table->string('password')->index();
            $table->text('password_reset_token')->nullable();
            $table->tinyInteger('is_admin')->default(0)->index();
            $table->tinyInteger('status')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('email_verifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('code', 64)->nullable()->index();
            $table->longText('token')->nullable();
            $table->tinyInteger('email_confirmed')->default(0)->index();
            $table->tinyInteger('is_expired')->default(0)->index();
            $table->dateTime('expired_at')->index();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 64)->unique();
            $table->string('name', 64)->unique();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('email_verifications');
    }
}
