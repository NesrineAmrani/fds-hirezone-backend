<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract 
{
    public function transform(Category $category) : array
    {
        return [
            'id' => (int) $category->id,
            'name' => $category->name,
            
        ];
    }
}

