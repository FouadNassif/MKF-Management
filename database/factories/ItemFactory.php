<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageURLArray = [
            'https://www.foodandwine.com/thmb/DI29Houjc_ccAtFKly0BbVsusHc=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/crispy-comte-cheesburgers-FT-RECIPE0921-6166c6552b7148e8a8561f7765ddf20b.jpg',
            'https://th.bing.com/th/id/R.a2c39123cd10af7ea726a659b0e082e9?rik=04cR0i6TGEg%2bgw&pid=ImgRaw&r=0',
            'https://images3.alphacoders.com/276/276815.jpg',
            'https://wallpapercave.com/wp/wp7029400.jpg',
            'https://besthqwallpapers.com/Uploads/22-2-2020/122844/fried-chicken-fried-food-fried-chicken-legs-4k-fast-food.jpg',
            'https://wallpaper.forfun.com/fetch/c5/c56e5904a171b851d843dd37401df5d7.jpeg'
        ];

        return [
            'name' => fake()->name(),
            'description' => fake()->text(200),
            'price' => fake()->randomFloat(null, 5, 200),
            'imageURL' => Arr::random($imageURLArray),
            'category_id' => fake()->randomDigitNotZero(),
        ];

    }
}
