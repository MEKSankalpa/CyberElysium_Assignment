<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(5);

        return view('products.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'image' => 'required',
            ''
        ]);
//        return $request;
    $pro=new Product();
    $pro->name = $request->name;
    $pro->detail = $request->detail;
    $pro->price = $request->price;
    $pro->status = $request->status;


        if($request->image){
            $file= $request->image;
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('/Image'), $filename);
            $pro->image=$filename;


        }





        $pro->save();

        return redirect()->route('products.index')
            ->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
//        $request->validate([
//            'name' => 'required',
//            'detail' => 'required',
//        ]);
        if($request->image){



            $image_path = "public/Images/".$product->image;  // Value is not URL but directory file path
            if(file_exists($image_path)) {
                @unlink($image_path);
            }
            $file= $request->image;
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('Image'), $filename);

            $product->image=$filename;


        }

            $product->name=$request->name;
            $product->price=$request->price;
            $product->status=$request->status;
            $product->detail=$request->detail;
            $product->save();




        return redirect()->route('products.index')
            ->with('success','Product updated successfully');
    }



//    public function updateDetail(Request $request,Product $products)
//    {
//        $request->validate([
//            'name' => 'required',
//            'detail' => 'required',
//        ]);
//
//        $products->update($request->all());
//
//        return redirect()->route('products.index')
//            ->with('success','Product updated successfully');
//    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $image_path =public_path()."/Images/".$product->image;  // Value is not URL but directory file path
        if(file_exists($image_path)) {
            unlink($image_path);
        }
        $product->delete();

        return redirect()->route('products.index')
            ->with('success','Product deleted successfully');
    }
}
