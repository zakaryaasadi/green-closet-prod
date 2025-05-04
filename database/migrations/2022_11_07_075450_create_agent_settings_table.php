<?php

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
        Schema::create('agent_settings', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class, 'agent_id')->index();

            $table->integer('tasks_per_day');
            $table->integer('holiday');
            $table->integer('budget');
            $table->time('start_work');
            $table->time('finish_work');
            $table->unsignedTinyInteger('work_shift');

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
        Schema::dropIfExists('agent_settings');
    }
};
