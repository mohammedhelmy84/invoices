<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::all();
        $products = Product::all();
        return view('products.products', compact('sections','products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validated = $request->validate([
         'product_name' => 'required|unique:products|max:100',
         'section_id' => 'required',
         'description' => 'required',
     ],[
         'product_name.required'=>'حقل اسم المنتج مطلوب',
         'product_name.unique'=>'حقل اسم المنتج لايتكرر',
         'product_name.max'=>'حقل اسم المنتج لايتجاوز 100 احرف',
         'section_id.required'=>'حقل اسم القسم مطلوب',
         'description.required'=>'حقل الوصف مطلوب',
     ]);

        Product::create([
            'product_name'=>$request->product_name,
            'section_id'=>$request->section_id,
            'description'=>$request->description,
        ]);

        session()->flash('Add','تم إضافة المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = Section::where('section_name', $request->section_name)->first()->id;

        $products = Product::findOrFail($request->pro_id);
 
        $products->update([
        'product_name' => $request->product_name,
        'description' => $request->description,
        'section_id' => $id,
        ]);
 
        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $products = Product::findOrFail($request->pro_id);
        $products->delete();
        session()->flash('Delete', 'تم حذف المنتج بنجاح');
        return back();
    }
}
