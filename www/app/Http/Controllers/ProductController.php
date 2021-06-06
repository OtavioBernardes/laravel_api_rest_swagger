<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{

    public function get()
    {
        /**
         * @OA\Get(
         *      path="/api/product",
         *      operationId="getProductList",
         *      tags={"Products"},
         *      summary="Get list of products",
         *      description="Returns list of products",
         *      @OA\Response(
         *          response=200,
         *          description="Successful operation",
         *       ),
         *      @OA\Response(
         *          response=401,
         *          description="Unauthenticated",
         *      ),
         *      @OA\Response(
         *          response=403,
         *          description="Forbidden"
         *      )
         *     )
         */
        
        $product = new Product;
        return response(
            json_encode($product->get()),
            200
        );
    }

    public function add(Request $request)
    {
        /**
         * @OA\Post(
         *      path="/api/product",
         *      operationId="addProduct",
         *      tags={"Products"},
         *      summary="Add product",
         *      @OA\RequestBody(
         *       @OA\JsonContent(
         *         type="object",
         *         @OA\Property(property="name", type="string"),
         *         @OA\Property(property="price", type="string")
         *        )
         *      ),
         *      @OA\Response(
         *          response=200,
         *          description="Successful operation",
         *       ),
         *      @OA\Response(
         *          response=401,
         *          description="Invalid data",
         *      ),
         *     )
         */

        $request = json_decode($request->getContent(), true);

        if ($this->validateProduct($request)) {

            return response('Invalid data', 401);
        }

        return response(
            json_encode(Product::create([
                'name' => $request['name'],
                'price' => $request['price'],
            ])),
            200
        );
    }

    public function delete($id)
    {
        /**
         * @OA\Delete(
         *      path="/api/product/{id}",
         *      operationId="deleteProduct",
         *      tags={"Products"},
         *      summary="Delete product",
         *  @OA\Parameter(
         *          name="id",
         *          description="Product id",
         *          required=true,
         *          in="path",
         *          @OA\Schema(
         *              type="integer"
         *          )
         *      ),
         *      @OA\Response(
         *          response=204,
         *          description="Successful operation",
         *       ),
         *     )
         */

        $product = Product::findOrfail($id);
        $product->delete();

        return response()->json(null, 204);
    }

    public function update(Request $request, $id)
    {
        /**
         * @OA\Put(
         *      path="/api/product/{id}",
         *      operationId="putProduct",
         *      tags={"Products"},
         *      summary="Update existing product",
         *      description="Returns updated product data",
         *      
         *  @OA\Parameter(
         *          name="id",
         *          description="Id",
         *          required=true,
         *          in="path",
         *          @OA\Schema(
         *              type="integer"
         *          )
         *      ),
         *     @OA\RequestBody(
         *       @OA\JsonContent(
         *         type="object",
         *         @OA\Property(property="name", type="string"),
         *         @OA\Property(property="price", type="string")
         *        )
         *      ),
         *      @OA\Response(
         *          response=204,
         *          description="Successful operation",
         *       ),
         *      @OA\Response(
         *          response=400,
         *          description="Invalid ID",
         *       ),
         *      @OA\Response(
         *          response=401,
         *          description="Invalid data",
         *       ),
         *    
         *     )
         */

        $request = json_decode($request->getContent(), true);

        if (!$id) {
            return response(
                'Invalid ID',
                400
            );
        }

        if ($this->validateProduct($request)) {

            return response('Invalid data', 401);
        }

        Product::where('id', $id)->update(
            [
                'name' => $request['name'],
                'price' => $request['price']
            ]
        );
        return response(Product::where('id', $id)->get(), 200);
    }

    public function validateProduct($request)
    {
        if (
            !isset($request['name']) or $request['name'] == ''
            or !isset($request['price']) or $request['price'] == ''
        ) {
            return true;
        }
    }
}
