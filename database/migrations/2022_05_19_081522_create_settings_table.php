<?php

use App\Models\Country;
use App\Models\Language;
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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Country::class)->nullable();
            $table->foreignIdFor(Country::class, 'default_country_id');
            $table->foreignIdFor(Language::class);

            $table->double('point_value');
            $table->double('point_count');
            $table->integer('point_expire');
            $table->integer('first_points');
            $table->integer('first_points_expire');

            $table->double('container_value');

            $table->string('slug');
            $table->string('email');
            $table->string('mail_receiver');
            $table->string('location');
            $table->string('phone');
            $table->string('header_title');
            $table->string('currency_ar')->nullable();
            $table->string('currency_en')->nullable();

            $table->integer('tasks_per_day')->nullable();
            $table->integer('holiday')->nullable();
            $table->integer('budget')->nullable();
            $table->time('start_work')->nullable();
            $table->time('finish_work')->nullable();
            $table->unsignedTinyInteger('work_shift')->nullable();

            $table->unsignedTinyInteger('auto_assign');

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
        Schema::dropIfExists('settings');
    }
};
