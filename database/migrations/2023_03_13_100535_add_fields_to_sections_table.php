<?php

use App\Models\Country;
use App\Models\Language;
use App\Models\Page;
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
        Schema::table('sections', function (Blueprint $table) {
            $table->foreignIdFor(Page::class)->nullable()->change();
            $table->foreignIdFor(Country::class)->nullable();
            $table->foreignIdFor(Language::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn(Country::class);
            $table->dropColumn(Language::class);
        });
    }
};
