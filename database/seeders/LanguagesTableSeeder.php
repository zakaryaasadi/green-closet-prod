<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->createLanguage(
            'العربية',
            'ar',
            false
        );
        $this->createLanguage(
            'English',
            'en',
            true
        );
    }

    private function createLanguage($name, $code, $default): void
    {
        Language::create([
            'name' => $name,
            'code' => $code,
            'default' => $default,
        ]);
    }
}
