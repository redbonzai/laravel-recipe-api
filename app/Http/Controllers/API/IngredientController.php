<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class IngredientController extends Controller
{
    use ApiResponder;
    
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $ingredients = Ingredient::all();
        return $this->successResponse(new IngredientResource($ingredients));
    }
    
    public function create()
    {
        //
    }
    
    /**
     * Create new ingredient and add it to a recipe
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
       try {
           $rules = [
               'recipe_id' => 'required|integer',
               'name' => 'required|string|max:50',
               'quantity' => 'required|string|max:255',
           ];
    
           $this->validate($request, $rules);
           $recipe = Recipe::findOrFail($request->recipe_id);
           $ingredient = Ingredient::create($request->all());
           
           $ingredient->recipe()->associate($recipe->id);
           $ingredient->save();
           
       } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 422);
       }
    
        return $this->successResponse($ingredient);
    }
    
    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $ingredient = Ingredient::findOrFail($id);
    
        $recipe = new IngredientResource($ingredient->recipe);
    
        $response = [
            'recipe' => $recipe,
            'ingredient' => $ingredient
        ];
    
        return $this->successResponse(new IngredientResource($response));
    }
    
    /**
     * Get ingredients by Recipe ID
     * @param $recipeId
     * @return JsonResponse
     */
    public function getIngredientsByRecipeId($recipeId): JsonResponse
    {
        $recipe = Recipe::findOrFail($recipeId);
        
        $ingredients = $recipe->ingredients;
        return $this->successResponse(new IngredientResource($ingredients));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    
    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $rules = [
                'name' => 'string|max:40',
                'quantity' => 'integer',
            ];
    
            $this->validate($request, $rules);
    
            $ingredient = Ingredient::findOrFail($id);
            $ingredient->fill($request->all());
    
            if ($ingredient->isClean()) {
                return $this->errorResponse(
                    'At least one value must change',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
    
            $ingredient->save();
    
            return $this->successResponse(new IngredientResource($ingredient));
            
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 422);
        }
    }

    /**
     * Remove the specified Ingredient.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->delete();
        
        return $this->successResponse(new IngredientResource($ingredient));
    }
}
