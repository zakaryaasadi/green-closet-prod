<?php

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
        Schema::table('news', function (Blueprint $table) {
            $table->string('alt')->nullable();
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->string('alt')->nullable();
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->string('alt')->nullable();
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->string('alt')->nullable();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->string('alt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('alt');
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('alt');
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn('alt');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('alt');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('alt');
        });
    }
};
