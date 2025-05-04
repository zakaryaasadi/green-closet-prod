<?php

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
        Schema::create('location_event_templates', function (Blueprint $table) {
            $table->id();

            $table->unsignedTinyInteger('event_type');
            $table->unsignedTinyInteger('channel');

            $table->string('content');

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
        Schema::dropIfExists('location_event_templates');
    }
};
