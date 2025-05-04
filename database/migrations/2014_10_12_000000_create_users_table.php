<?php

use App\Enums\LanguageEnum;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Country;
use App\Models\Location;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique();

            $table->foreignIdFor(Country::class)->nullable();
            $table->foreignIdFor(Team::class)->nullable();
            $table->foreignIdFor(Location::class)->nullable();

            $table->unsignedTinyInteger('language')->default(LanguageEnum::EN);
            $table->unsignedTinyInteger('type')->default(UserType::CLIENT);
            $table->unsignedTinyInteger('status')->default(UserStatus::ENABLE);

            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();

            $table->string('password')->nullable();
            $table->string('image')->nullable();

            $table->rememberToken();

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
        Schema::dropIfExists('users');
    }
};
