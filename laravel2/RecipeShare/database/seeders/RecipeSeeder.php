<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@recipeshare.test')->first()
            ?? User::factory()->admin()->create([
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@recipeshare.test',
            ]);

        foreach ($this->recipes() as $data) {
            $recipe = Recipe::create([
                'user_id' => $admin->id,
                'title' => $data['title'],
                'description' => $data['description'],
                'prep_time' => $data['prep_time'],
                'cook_time' => $data['cook_time'],
                'servings' => $data['servings'],
                'image' => null,
            ]);

            foreach ($data['ingredients'] as $ingredient) {
                $recipe->ingredients()->create($ingredient);
            }

            $tagIds = collect($data['tags'])
                ->map(fn (string $name): int => Tag::firstOrCreate(
                    ['slug' => Str::slug($name)],
                    ['name' => $name]
                )->id);

            $recipe->tags()->sync($tagIds);
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function recipes(): array
    {
        return [
            [
                'title' => 'Classic Spaghetti Carbonara',
                'description' => "A Roman pasta classic with crispy guanciale, eggs and pecorino. No cream — the silkiness comes from emulsifying the egg with the starchy pasta water.\n\nServe immediately while it's hot and creamy.",
                'prep_time' => 10,
                'cook_time' => 15,
                'servings' => 4,
                'tags' => ['Dinner', 'Italian', 'Pasta'],
                'ingredients' => [
                    ['amount' => '400', 'unit' => 'g', 'name' => 'spaghetti'],
                    ['amount' => '150', 'unit' => 'g', 'name' => 'guanciale'],
                    ['amount' => '4', 'unit' => '', 'name' => 'egg yolks'],
                    ['amount' => '1', 'unit' => '', 'name' => 'whole egg'],
                    ['amount' => '80', 'unit' => 'g', 'name' => 'pecorino romano, grated'],
                    ['amount' => '1', 'unit' => 'tsp', 'name' => 'black pepper, freshly ground'],
                ],
            ],
            [
                'title' => 'Tomato Basil Soup',
                'description' => 'Roasted tomatoes blended with fresh basil for a soup that tastes like summer. Pairs perfectly with a grilled cheese on the side.',
                'prep_time' => 10,
                'cook_time' => 35,
                'servings' => 4,
                'tags' => ['Soup', 'Vegetarian', 'Lunch'],
                'ingredients' => [
                    ['amount' => '1', 'unit' => 'kg', 'name' => 'ripe tomatoes'],
                    ['amount' => '1', 'unit' => '', 'name' => 'onion, chopped'],
                    ['amount' => '3', 'unit' => 'cloves', 'name' => 'garlic'],
                    ['amount' => '2', 'unit' => 'tbsp', 'name' => 'olive oil'],
                    ['amount' => '500', 'unit' => 'ml', 'name' => 'vegetable stock'],
                    ['amount' => '1', 'unit' => 'handful', 'name' => 'fresh basil'],
                    ['amount' => '1', 'unit' => 'tsp', 'name' => 'salt'],
                ],
            ],
            [
                'title' => 'Fluffy Buttermilk Pancakes',
                'description' => "Tall, airy pancakes with a slight tang from the buttermilk. The trick: don't overmix — lumps are fine.",
                'prep_time' => 10,
                'cook_time' => 15,
                'servings' => 4,
                'tags' => ['Breakfast', 'Vegetarian', 'Quick'],
                'ingredients' => [
                    ['amount' => '250', 'unit' => 'g', 'name' => 'all-purpose flour'],
                    ['amount' => '2', 'unit' => 'tbsp', 'name' => 'sugar'],
                    ['amount' => '1', 'unit' => 'tsp', 'name' => 'baking powder'],
                    ['amount' => '1', 'unit' => 'tsp', 'name' => 'baking soda'],
                    ['amount' => '1', 'unit' => 'tsp', 'name' => 'salt'],
                    ['amount' => '500', 'unit' => 'ml', 'name' => 'buttermilk'],
                    ['amount' => '2', 'unit' => '', 'name' => 'eggs'],
                    ['amount' => '60', 'unit' => 'g', 'name' => 'butter, melted'],
                ],
            ],
            [
                'title' => 'Thai Green Curry with Chicken',
                'description' => 'Fragrant, spicy and rich coconut curry. Use a good quality green curry paste — it makes all the difference.',
                'prep_time' => 15,
                'cook_time' => 25,
                'servings' => 4,
                'tags' => ['Dinner', 'Thai', 'Spicy'],
                'ingredients' => [
                    ['amount' => '500', 'unit' => 'g', 'name' => 'chicken thigh, sliced'],
                    ['amount' => '3', 'unit' => 'tbsp', 'name' => 'green curry paste'],
                    ['amount' => '400', 'unit' => 'ml', 'name' => 'coconut milk'],
                    ['amount' => '1', 'unit' => '', 'name' => 'aubergine, cubed'],
                    ['amount' => '1', 'unit' => 'handful', 'name' => 'Thai basil'],
                    ['amount' => '2', 'unit' => 'tbsp', 'name' => 'fish sauce'],
                    ['amount' => '1', 'unit' => 'tbsp', 'name' => 'palm sugar'],
                    ['amount' => '2', 'unit' => '', 'name' => 'kaffir lime leaves'],
                ],
            ],
            [
                'title' => 'Chocolate Chip Cookies',
                'description' => 'Crispy edges, chewy centers. Chill the dough overnight if you can — the flavor deepens dramatically.',
                'prep_time' => 15,
                'cook_time' => 12,
                'servings' => 24,
                'tags' => ['Dessert', 'Baking', 'Vegetarian'],
                'ingredients' => [
                    ['amount' => '225', 'unit' => 'g', 'name' => 'butter, softened'],
                    ['amount' => '150', 'unit' => 'g', 'name' => 'brown sugar'],
                    ['amount' => '100', 'unit' => 'g', 'name' => 'white sugar'],
                    ['amount' => '2', 'unit' => '', 'name' => 'eggs'],
                    ['amount' => '1', 'unit' => 'tsp', 'name' => 'vanilla extract'],
                    ['amount' => '300', 'unit' => 'g', 'name' => 'flour'],
                    ['amount' => '1', 'unit' => 'tsp', 'name' => 'baking soda'],
                    ['amount' => '300', 'unit' => 'g', 'name' => 'chocolate chips'],
                ],
            ],
            [
                'title' => 'Quick Veggie Stir-Fry',
                'description' => 'Weeknight savior: 15 minutes from fridge to plate. Cut everything before you turn on the heat — stir-fry waits for no one.',
                'prep_time' => 10,
                'cook_time' => 8,
                'servings' => 2,
                'tags' => ['Dinner', 'Vegan', 'Quick'],
                'ingredients' => [
                    ['amount' => '1', 'unit' => '', 'name' => 'broccoli head, in florets'],
                    ['amount' => '1', 'unit' => '', 'name' => 'red bell pepper, sliced'],
                    ['amount' => '2', 'unit' => '', 'name' => 'carrots, julienned'],
                    ['amount' => '3', 'unit' => 'cloves', 'name' => 'garlic, minced'],
                    ['amount' => '1', 'unit' => 'tbsp', 'name' => 'ginger, grated'],
                    ['amount' => '3', 'unit' => 'tbsp', 'name' => 'soy sauce'],
                    ['amount' => '1', 'unit' => 'tbsp', 'name' => 'sesame oil'],
                    ['amount' => '1', 'unit' => 'tbsp', 'name' => 'vegetable oil'],
                ],
            ],
            [
                'title' => 'Greek Salad',
                'description' => 'No lettuce, no shortcuts. Just ripe tomatoes, crunchy cucumber, sharp red onion, briny olives and a generous slab of feta.',
                'prep_time' => 15,
                'cook_time' => 0,
                'servings' => 4,
                'tags' => ['Salad', 'Vegetarian', 'Lunch', 'Quick'],
                'ingredients' => [
                    ['amount' => '4', 'unit' => '', 'name' => 'large tomatoes, cut in wedges'],
                    ['amount' => '1', 'unit' => '', 'name' => 'cucumber, sliced'],
                    ['amount' => '1', 'unit' => '', 'name' => 'red onion, thinly sliced'],
                    ['amount' => '100', 'unit' => 'g', 'name' => 'kalamata olives'],
                    ['amount' => '200', 'unit' => 'g', 'name' => 'feta, in one slab'],
                    ['amount' => '3', 'unit' => 'tbsp', 'name' => 'olive oil'],
                    ['amount' => '1', 'unit' => 'tsp', 'name' => 'dried oregano'],
                ],
            ],
            [
                'title' => 'Banana Bread',
                'description' => "The riper the bananas, the better. Black, spotty, slightly mushy — that's the dream.",
                'prep_time' => 10,
                'cook_time' => 55,
                'servings' => 8,
                'tags' => ['Baking', 'Breakfast', 'Vegetarian'],
                'ingredients' => [
                    ['amount' => '3', 'unit' => '', 'name' => 'very ripe bananas, mashed'],
                    ['amount' => '120', 'unit' => 'g', 'name' => 'butter, melted'],
                    ['amount' => '150', 'unit' => 'g', 'name' => 'sugar'],
                    ['amount' => '1', 'unit' => '', 'name' => 'egg'],
                    ['amount' => '1', 'unit' => 'tsp', 'name' => 'vanilla extract'],
                    ['amount' => '200', 'unit' => 'g', 'name' => 'flour'],
                    ['amount' => '1', 'unit' => 'tsp', 'name' => 'baking soda'],
                    ['amount' => '0.5', 'unit' => 'tsp', 'name' => 'salt'],
                ],
            ],
            [
                'title' => 'Margherita Pizza',
                'description' => 'A great pizza is three ingredients done right: good tomatoes, fresh mozzarella, and a hot oven (the hotter the better).',
                'prep_time' => 90,
                'cook_time' => 10,
                'servings' => 2,
                'tags' => ['Dinner', 'Italian', 'Vegetarian'],
                'ingredients' => [
                    ['amount' => '300', 'unit' => 'g', 'name' => 'pizza dough'],
                    ['amount' => '100', 'unit' => 'g', 'name' => 'San Marzano tomatoes, crushed'],
                    ['amount' => '150', 'unit' => 'g', 'name' => 'fresh mozzarella'],
                    ['amount' => '8', 'unit' => '', 'name' => 'basil leaves'],
                    ['amount' => '2', 'unit' => 'tbsp', 'name' => 'olive oil'],
                    ['amount' => '1', 'unit' => 'pinch', 'name' => 'salt'],
                ],
            ],
            [
                'title' => 'Beef Bourguignon',
                'description' => 'Slow-braised beef in red wine, mushrooms, bacon and pearl onions. Worth every minute of the cook time.',
                'prep_time' => 30,
                'cook_time' => 180,
                'servings' => 6,
                'tags' => ['Dinner', 'French', 'Slow Cook'],
                'ingredients' => [
                    ['amount' => '1.5', 'unit' => 'kg', 'name' => 'beef chuck, cubed'],
                    ['amount' => '200', 'unit' => 'g', 'name' => 'smoked bacon, diced'],
                    ['amount' => '750', 'unit' => 'ml', 'name' => 'red Burgundy wine'],
                    ['amount' => '500', 'unit' => 'ml', 'name' => 'beef stock'],
                    ['amount' => '250', 'unit' => 'g', 'name' => 'pearl onions'],
                    ['amount' => '300', 'unit' => 'g', 'name' => 'mushrooms, quartered'],
                    ['amount' => '3', 'unit' => '', 'name' => 'carrots, chopped'],
                    ['amount' => '3', 'unit' => 'tbsp', 'name' => 'flour'],
                    ['amount' => '2', 'unit' => 'tbsp', 'name' => 'tomato paste'],
                ],
            ],
            [
                'title' => 'Avocado Toast',
                'description' => "Embarrassingly simple, embarrassingly delicious. Good bread, ripe avocado, flaky salt — don't overthink it.",
                'prep_time' => 5,
                'cook_time' => 3,
                'servings' => 1,
                'tags' => ['Breakfast', 'Vegan', 'Quick'],
                'ingredients' => [
                    ['amount' => '2', 'unit' => 'slices', 'name' => 'sourdough bread'],
                    ['amount' => '1', 'unit' => '', 'name' => 'ripe avocado'],
                    ['amount' => '1', 'unit' => 'pinch', 'name' => 'flaky sea salt'],
                    ['amount' => '1', 'unit' => 'squeeze', 'name' => 'lemon juice'],
                    ['amount' => '1', 'unit' => 'pinch', 'name' => 'chili flakes'],
                    ['amount' => '1', 'unit' => 'drizzle', 'name' => 'olive oil'],
                ],
            ],
            [
                'title' => 'Chicken Tikka Masala',
                'description' => 'Yogurt-marinated chicken in a creamy spiced tomato sauce. The marinade is the soul of this dish — give it time.',
                'prep_time' => 30,
                'cook_time' => 30,
                'servings' => 4,
                'tags' => ['Dinner', 'Indian', 'Spicy'],
                'ingredients' => [
                    ['amount' => '700', 'unit' => 'g', 'name' => 'chicken thigh, cubed'],
                    ['amount' => '200', 'unit' => 'g', 'name' => 'Greek yogurt'],
                    ['amount' => '4', 'unit' => 'tbsp', 'name' => 'garam masala'],
                    ['amount' => '400', 'unit' => 'g', 'name' => 'crushed tomatoes'],
                    ['amount' => '200', 'unit' => 'ml', 'name' => 'heavy cream'],
                    ['amount' => '3', 'unit' => 'cloves', 'name' => 'garlic, minced'],
                    ['amount' => '1', 'unit' => 'tbsp', 'name' => 'ginger, grated'],
                    ['amount' => '1', 'unit' => '', 'name' => 'onion, chopped'],
                    ['amount' => '2', 'unit' => 'tbsp', 'name' => 'ghee'],
                ],
            ],
        ];
    }
}
