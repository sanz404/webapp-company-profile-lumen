<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // articles
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->longText('image')->nullable();
            $table->string('slug', 64)->unique();
            $table->string('title', 64)->unique();
            $table->longText('content')->nullable();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // category_articles
        Schema::create('category_articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64);
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // articles_categories
        Schema::create('articles_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id')->index();
            $table->unsignedBigInteger('category_id')->index();
            $table->primary(["article_id", "category_id"]);
            $table->engine = 'InnoDB';
        });

        // articles_comments
        Schema::create('articles_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('article_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // projects
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->index();
            $table->string('name', 64);
            $table->text('image')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // category_projects
        Schema::create('category_projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64);
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // products
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->index();
            $table->string('name', 64);
            $table->text('image')->nullable();
            $table->decimal('price', 18, 4)->default(0)->index();
            $table->longText('description')->nullable();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // category_faqs
        Schema::create('category_faqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64);
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // category_products
        Schema::create('category_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64);
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // faqs
        Schema::create('faqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->index();
            $table->string('question', 100);
            $table->longText('answer');
            $table->Integer('sort')->default(0)->index();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // messages
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name', 64);
            $table->string('email', 64);
            $table->string('phone', 64);
            $table->longText('message')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // teams
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('image')->nullable();
            $table->string('name', 64);
            $table->string('position', 64);
            $table->longText('description')->nullable();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // contents
        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key_name', 64)->unique();
            $table->longText('key_value');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // abouts
        Schema::create('abouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('image')->nullable();
            $table->string('title', 64);
            $table->longText('description')->nullable();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // features
        Schema::create('features', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('icon')->nullable();
            $table->string('title', 64);
            $table->longText('description')->nullable();
            $table->tinyInteger('is_published')->default(0)->index();
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
        Schema::dropIfExists('articles');
        Schema::dropIfExists('category_articles');
        Schema::dropIfExists('articles_categories');
        Schema::dropIfExists('articles_comments');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('category_projects');
        Schema::dropIfExists('products');
        Schema::dropIfExists('category_products');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('category_faqs');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('contents');
        Schema::dropIfExists('abouts');
        Schema::dropIfExists('features');
    }
}
