<?php

use App\Enums\ExpenseStatus;
use App\Models\Association;
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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Association::class);

            $table->integer('containers_count');
            $table->integer('orders_count');

            $table->double('orders_weight');
            $table->double('containers_weight');

            $table->double('weight');
            $table->double('value');

            $table->dateTime('date');

            $table->unsignedTinyInteger('status')->default(ExpenseStatus::PROCESSING);

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
        Schema::dropIfExists('expenses');
    }
};
