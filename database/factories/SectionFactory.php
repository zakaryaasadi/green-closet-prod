<?php

namespace Database\Factories;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class SectionFactory extends Factory
{
    protected $model = Section::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->numberBetween(1, 11),
            'sort' => $this->faker->numberBetween(0, 100),
            'active' => $this->faker->boolean,
            'structure' => [
                'title' => 'title',
                'description' => 'description',
            ],
            'page_id' => Page::factory()->create()->id,
        ];
    }
}
