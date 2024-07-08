<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username', 64)->unique();
            $table->string('email', 64)->unique();
            $table->string('phone', 64)->unique()->nullable();
            $table->string('password');
            $table->tinyInteger('is_admin')->default(0)->index();
            $table->tinyInteger('is_banned')->default(0)->index();
            $table->tinyInteger('verified')->default(0)->index();
            $table->string('verification_token', 255)->nullable()->index();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('auth_persons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->text('image')->nullable();
            $table->string('nick_name', 64)->nullable()->index();
            $table->string('full_name', 64)->nullable()->index();
            $table->tinyInteger('gender')->default(0)->index();
            $table->date('birth_date')->nullable()->index();
            $table->text('twitter')->nullable();
            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->longtext('address')->nullable();
            $table->longtext('about_me')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('auth_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('subject', 45)->nullable()->index();
            $table->longText('content');
            $table->timestamps();
            $table->dateTime('readed_at')->nullable()->index();
            $table->engine = 'InnoDB';
        });

        Schema::create('auth_password_resets', function (Blueprint $table) {
            $table->string('email', 64)->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_users');
        Schema::dropIfExists('auth_persons');
        Schema::dropIfExists('auth_notifications');
        Schema::dropIfExists('auth_password_resets');
    }
}
