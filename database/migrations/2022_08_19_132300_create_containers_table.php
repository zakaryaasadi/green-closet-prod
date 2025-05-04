<?php

use App\Models\Association;
use App\Models\Country;
use App\Models\District;
use App\Models\Neighborhood;
use App\Models\Province;
use App\Models\Street;
use App\Models\Team;
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
        Schema::create('containers', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Team::class)->index();
            $table->foreignIdFor(Association::class)->nullable()->index();

            $table->foreignIdFor(Country::class);
            $table->foreignIdFor(Province::class);
            $table->foreignIdFor(District::class);
            $table->foreignIdFor(Neighborhood::class);
            $table->foreignIdFor(Street::class);

            $table->unsignedTinyInteger('status');
            $table->unsignedTinyInteger('type');
            $table->unsignedTinyInteger('discharge_shift');

            $table->string('code');
            $table->string('location_description');

            $table->point('location');

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
        Schema::dropIfExists('containers');
    }
};
