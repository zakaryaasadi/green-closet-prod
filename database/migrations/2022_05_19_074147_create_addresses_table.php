<?php

use App\Enums\AddressType;
use App\Models\User;
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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class);

            $table->point('location');
            $table->string('location_title')->nullable();
            $table->string('location_province')->nullable();

            $table->unsignedTinyInteger('type')->default(AddressType::OTHER);

            $table->boolean('default')->default(false);


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
        Schema::dropIfExists('addresses');
    }
};
