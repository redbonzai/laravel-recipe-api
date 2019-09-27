<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\IngredientResource;
use App\Http\Resources\RecipeResource;
use App\Http\Resources\StepResource;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class StepController extends Controller
{
    use ApiResponder;
    
    /**
     * Show all steps in storage
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $steps = Step::all();
        return $this->successResponse(new StepResource($steps));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Add a step to a recipe.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $rules = [
                'recipe_id' => 'required|integer',
                'step_order' => 'required|integer|max:50',
                'description' => 'required|string|max:255',
            ];
        
            $this->validate($request, $rules);
            $recipe = Recipe::findOrFail($request->recipe_id);
            $step = Step::create($request->all());
        
            $step->recipe()->associate($recipe->id);
            $step->save();
        
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 422);
        }
    
        return $this->successResponse(new StepResource($step));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $step = Step::findOrFail($id);
    
        $recipe = new RecipeResource($step->recipe);
    
        $response = [
            'recipe' => $recipe,
            'step' => $step
        ];
    
        return $this->successResponse(new StepResource($response));
    }
    
    /**
     * Get ingredients by Recipe ID
     * @param $recipeId
     * @return JsonResponse
     */
    public function getStepsByRecipeId($recipeId): JsonResponse
    {
        $recipe = Recipe::findOrFail($recipeId);
        
        $steps = $recipe->steps;
        return $this->successResponse(new StepResource($steps));
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
     * Update an existing recipe step
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $rules = [
                'step_order' => 'integer|max:50',
                'description' => 'string|max:255',
            ];
        
            $this->validate($request, $rules);
        
            $step = Step::findOrFail($id);
            $step->fill($request->all());
        
            if ($step->isClean()) {
                return $this->errorResponse(
                    'At least one value must change',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
        
            $step->save();
        
            return $this->successResponse(new StepResource($step));
        
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 422);
        }
    }

    /**
     * Remove the specified Recipe Step from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $step = Step::findOrFail($id);
        $step->delete();
    
        return $this->successResponse(new StepResource($step));
    }
}
