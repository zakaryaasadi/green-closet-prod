<?php

use App\Models\Country;
use App\Models\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('default_page_title');

            $table->boolean('is_home')->default(false);
            $table->string('slug');

            $table->json('meta_tags')->nullable();

            $table->text('custom_styles')->nullable();
            $table->text('custom_scripts')->nullable();

            $table->foreignIdFor(Country::class)->index();
            $table->foreignIdFor(Language::class)->index();

            $table->softDeletes();
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
        Schema::dropIfExists('pages');
    }
};
