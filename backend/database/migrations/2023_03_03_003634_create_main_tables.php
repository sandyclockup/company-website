<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         // settings
         Schema::create('core_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key_name', 64)->unique()->index();
            $table->longtext('key_value');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // contact
        Schema::create('cms_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64)->index();
            $table->string('email', 64)->index();
            $table->string('subject', 64)->index();
            $table->text('message');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // sliders
        Schema::create('cms_sliders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('image')->nullable();
            $table->string('title', 64)->index();
            $table->text('description');
            $table->text('link')->nullable();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->Integer('sort')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // services
        Schema::create('cms_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('icon')->nullable();
            $table->string('title', 64)->index();
            $table->text('description')->nullable();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->Integer('sort')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // features
        Schema::create('cms_features', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('icon')->nullable();
            $table->string('title', 64)->index();
            $table->text('description')->nullable();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->Integer('sort')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // categories
        Schema::create('cms_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->string('slug')->index();
            $table->Integer('type')->default(0)->index();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // customers
        Schema::create('cms_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('image')->nullable();
            $table->string('name', 64)->index();
            $table->string('email', 64)->index();
            $table->string('phone', 64)->index();
            $table->text('address')->nullable();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // portfolios
        Schema::create('cms_portfolios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('category_id')->index();
            $table->string('title', 64)->index();
            $table->text('description')->nullable();
            $table->date('project_date')->nullable()->index();
            $table->text('project_url')->nullable();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->Integer('sort')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // portfolios_images
        Schema::create('cms_portfolios_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('portfolio_id')->index();
            $table->text('image');
            $table->tinyInteger('is_primary')->default(0)->index();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // teams
        Schema::create('cms_teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('image')->nullable();
            $table->string('name', 64)->index();
            $table->string('email', 64)->index();
            $table->string('phone', 64)->index();
            $table->string('position_name', 64)->index();
            $table->Integer('sort')->default(0)->index();
            $table->text('twitter')->nullable();
            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->text('linked_in')->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // skills
        Schema::create('cms_skills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64)->index();
            $table->text('description')->nullable();
            $table->decimal('index_ratio', 18, 4)->default(0)->index();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->Integer('sort')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // testiomonials
        Schema::create('cms_testimonials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id')->index();
            $table->text('image')->nullable();
            $table->string('name', 64)->index();
            $table->string('position', 64)->index();
            $table->text('quote')->nullable();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->Integer('sort')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // pricings
        Schema::create('cms_pricings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64)->index();
            $table->decimal('price', 18, 4)->default(0)->index();
            $table->string('unit', 64)->index();
            $table->text('description')->nullable();
            $table->text('link')->nullable();
            $table->tinyInteger('is_recomended')->default(0)->index();
            $table->tinyInteger('is_advanced')->default(0)->index();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->Integer('sort')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // faq
        Schema::create('cms_faqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question')->index();
            $table->text('answer')->nullable();
            $table->tinyInteger('is_published')->default(0)->index();
            $table->Integer('sort')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });


        // articles
        Schema::create('cms_articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->text('image')->nullable();
            $table->string('title', 191)->unique();
            $table->string('slug', 191)->unique();
            $table->longText('content');
            $table->tinyInteger('is_published')->default(0)->index();
            $table->Integer('sort')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('cms_articles_references', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('article_id')->index();
            $table->unsignedBigInteger('category_id')->index();
            $table->tinyInteger('type')->default(0)->index();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('cms_articles_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->unsignedBigInteger('article_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->longText('comment');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('cms_articles_counters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('article_id')->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable()->index();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // visitors
        Schema::create('cms_visitors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip_address', 45)->nullable()->index();
            $table->text('url');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // Newsletter
        Schema::create('cms_newsletter', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->timestamps();
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
        Schema::dropIfExists('core_settings');
        Schema::dropIfExists('cms_contacts');
        Schema::dropIfExists('cms_sliders');
        Schema::dropIfExists('cms_services');
        Schema::dropIfExists('cms_features');
        Schema::dropIfExists('cms_categories');
        Schema::dropIfExists('cms_customers');
        Schema::dropIfExists('cms_portfolios');
        Schema::dropIfExists('cms_portfolios_images');
        Schema::dropIfExists('cms_teams');
        Schema::dropIfExists('cms_skills');
        Schema::dropIfExists('cms_testimonials');
        Schema::dropIfExists('cms_pricings');
        Schema::dropIfExists('cms_faqs');
        Schema::dropIfExists('cms_articles');
        Schema::dropIfExists('cms_articles_references');
        Schema::dropIfExists('cms_articles_comments');
        Schema::dropIfExists('cms_articles_counters');
        Schema::dropIfExists('cms_visitors');
        Schema::dropIfExists('cms_newsletter');
    }
}
