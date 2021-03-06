<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;
use App\Model\Product;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\response;
use App\Exceptions\ProductNotBelongToUSer;
use Auth;

class ProductController extends Controller
{

    public function __construct()
    {
         $this->middleware('auth:api')->except('index','show');
         
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductCollection::collection(Product::paginate(20));
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product();

        $product->name          = $request->name;
        $product->detail   = $request->description;
        $product->stock         = $request->stock;
        $product->price         = $request->price;
        $product->discount      = $request->discount;

        $product->save();

        return response([
            'data' => new ProductResource( $product),
        ])->setStatusCode(201, 'The resource is created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // check current user can edit
        $this->ProductUserCheck($product);

        $request['detail'] = $request->description;
        unset($request['description']);
        $product->update($request->all());
        return response([
            'data' => new ProductResource( $product),
        ])->setStatusCode(201, 'The resource is created successfully!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // check current user can edit
        $this->ProductUserCheck($product);

        $product->delete();
        return response('Successfull delete Content');
    }

    public function ProductUserCheck($product)
    {
        if(Auth::id() !== $product->user_regis_id){
            throw new ProductNotBelongToUSer();
        }
    }
}
