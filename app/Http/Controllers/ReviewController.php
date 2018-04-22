<?php

namespace App\Http\Controllers;

use App\Model\Review;
use App\Model\Product;
use App\Http\Resources\Review\ReviewResource;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\response;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return ReviewResource::collection($product->reviews);
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
    public function store(ReviewRequest $request,Product $product)
    {
        // create review object
        $review = new Review($request->all());

        // save review to product
        $product->reviews()->save($review);

        return response([
            'data' => new ReviewResource($review),
        ])->setStatusCode(201, 'The resource is created successfully!');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product,Review $review)
    {
         return new ReviewResource($review);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Product $product, Review $review)
    {
        $review->update($request->all());
        return response([
            'data' => new ReviewResource($review),
        ])->setStatusCode(201, 'The review is update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product ,Review $review)
    {
        $review->delete();
        return response('Successfull delete Content');
    }
}
