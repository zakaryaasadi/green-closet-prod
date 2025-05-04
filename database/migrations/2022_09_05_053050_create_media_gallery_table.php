<?php

use App\Enums\MediaType;
use App\Models\Country;
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
        Schema::create('media_models', function (Blueprint $table) {
            $table->id();

            $table->string('media');
            $table->string('tag');

            $table->unsignedTinyInteger('type')->default(MediaType::IMAGE);

            $table->foreignIdFor(Country::class)->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_gallery');
    }
};
