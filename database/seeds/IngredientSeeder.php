<?php
    
    use App\Models\Ingredient;
    use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Ingredient::class, 20)->create();
    }
}
