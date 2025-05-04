<?php

use App\Enums\PointStatus;
use App\Models\Country;
use App\Models\Order;
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
        Schema::create('points', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Country::class)->nullable()->index();

            $table->unsignedBigInteger('count');

            $table->unsignedTinyInteger('status')->default(PointStatus::ACTIVE);
            $table->boolean('used')->default(false);

            $table->dateTime('ends_at');


            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Order::class)->nullable();

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
        Schema::dropIfExists('points');
    }
};
