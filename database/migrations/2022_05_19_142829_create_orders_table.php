<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Models\Address;
use App\Models\Association;
use App\Models\Country;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Country::class)->index();
            $table->foreignIdFor(User::class, 'customer_id')->nullable()->index();
            $table->foreignIdFor(User::class, 'agent_id')->nullable()->index();
            $table->foreignIdFor(Address::class)->nullable();
            $table->foreignIdFor(Association::class)->nullable();

            $table->point('location')->nullable();

            $table->unsignedTinyInteger('status')->default(OrderStatus::CREATED);
            $table->unsignedTinyInteger('type')->default(OrderType::DONATION);
            $table->unsignedTinyInteger('payment_status')->nullable();

            $table->string('image')->nullable();
            $table->string('total_time')->nullable();
            $table->string('failed_message')->nullable();
            $table->string('platform');

            $table->dateTime('start_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->date('start_task')->nullable();

            $table->unsignedMediumInteger('weight')->nullable();
            $table->double('value')->nullable();
            $table->double('payment_remaining')->nullable();
            $table->double('agent_payment')->nullable();

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
        Schema::dropIfExists('orders');
    }
};
