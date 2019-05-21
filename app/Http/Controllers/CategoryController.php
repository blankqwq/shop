<?php

namespace App\Http\Controllers;

use App\Models\GoodsCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($id){
        $categories = GoodsCategory::with('goods')->where('parent_id',$id)->get();

        return view('goods.list',compact('categories'));
    }
}
