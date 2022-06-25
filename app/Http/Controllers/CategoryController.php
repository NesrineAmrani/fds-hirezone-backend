<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Transformers\CategoryTransformer;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return $this->response->collection($categories , new CategoryTransformer);
        //return $categories;
        //return $this->response->array($categories->toArray());
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => [
                'required', 'string', 'min:3', 'max:30'
            ],
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'validation errors' => $validator->errors()
            ]);
        }

        $category = Category::create($request->all());

        $response = [
            'message' => 'Category created successfully',
            'id' => $category->id,
        ];

        return response()->json($response)->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (! $category) {
            throw new NotFoundHttpException('Category does not exist');
        }
        return $this->response->item($category, new CategoryTransformer);
    }

    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            throw new NotFoundHttpException('Category does not exist');
        }
        if( !empty($request->name)) {

            $rules = [
                'name' => [
                    'required', 'string', 'min:3', 'max:30'
                ],
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'validation errors' => $validator->errors()
                ]);
            }

            $category->name = $request->name;
        }

        if($category->isDirty()) {
            $category->save();
            $response = [
                'message' => 'Category updated successfully',
                'id' => $category->id,
            ];

            return response()->json($response, 200);
        }

        return response()->json(['message' => 'Nothing to update'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            throw new NotFoundHttpException('Category does not exist');
        }

        try {
            $category->delete();

            $response = [
                'message' => 'Category deleted successfully',
                'id' => $category->id,
            ];

            return response()->json($response, 200);

        } catch (HttpException $th) {
            throw $th;
        }
    }

}
