<?php
    
    use App\Models\Recipe;
    use App\Models\Step;
    use Illuminate\Database\Seeder;

class StepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Step::class, 20)->create();
    }
}
