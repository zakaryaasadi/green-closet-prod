<?php

use App\Enums\PaymentStatus;
use App\Models\Container;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_details', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class, 'agent_id');
            $table->foreignIdFor(Container::class);

            $table->double('weight');
            $table->double('value')->nullable();
            $table->double('status')->default(PaymentStatus::UNPAID);
            $table->dateTime('date');

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
        Schema::dropIfExists('container_details');
    }
};
