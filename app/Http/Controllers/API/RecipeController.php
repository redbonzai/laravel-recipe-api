<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\RecipeResource;
use App\Http\Resources\UserResource;
use App\Models\Recipe;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    use ApiResponder;
    
    public function index(): JsonResponse
    {
        $recipes = Recipe::with(['ingredients', 'steps'])->get();
        return $this->successResponse($recipes);
        
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

    public function store(Request $request): JsonResponse
    {
        $rules = [
            'user_id' => 'required|integer',
            'title' => 'required|string|max:50',
            'description' => 'required|string',
        ];
        
        $user = Auth::guard('api')->user();
        $request->request->add(['user_id' => $user->id]);
        $this->validate($request, $rules);
    
        $recipe = Recipe::create($request->all());
        
        return $this->successResponse(new RecipeResource($recipe));
    }
    
    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $recipe = Recipe::findOrFail($id);
        
        $user = new UserResource($recipe->user);
        
        $response = [
            'recipe' => $recipe,
            'user' => $user
        ];
        
        return $this->successResponse(new RecipeResource($response));
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
        $rules = [
            //'user_id' => 'required|integer',
            'title' => 'string|max:50',
            'description' => 'string',
        ];
        
        $this->validate($request, $rules);
        
        $recipe = Recipe::findOrFail($id);
        $recipe->fill($request->all());
        
        if ($recipe->isClean()) {
            return $this->errorResponse(
                'At least one value must change',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        
        $recipe->save();
        return $this->successResponse(new RecipeResource($recipe));
    }
    
    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();
        
        return $this->successResponse(new RecipeResource($recipe));
    }
}
