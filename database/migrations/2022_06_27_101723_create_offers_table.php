<?php

use App\Enums\OfferType;
use App\Models\Country;
use App\Models\Partner;
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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('image_path')->nullable();
            $table->unsignedMediumInteger('value');

            $table->json('meta');

            $table->unsignedTinyInteger('type')->default(OfferType::FIXED);

            $table->foreignIdFor(Country::class)->index();
            $table->foreignIdFor(Partner::class);

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
        Schema::dropIfExists('offers');
    }
};
