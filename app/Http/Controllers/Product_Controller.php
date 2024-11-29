<?php

namespace App\Http\Controllers;

use App\Models\Product; // esto es para que se pueda usar el modelo Product
use App\Http\Controllers\Controller; //
use Illuminate\Http\Request;

class Product_Controller extends Controller
{
    public function index(){ // este metodo se usa para obtener todos los productos
        $products = Product::all();
        return response()->json(['products' => $products], 200);
    }

    public function store(Request $request){ 
        $validated= $request->validate([
            //validar los datos
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|min:0',
            'stock' => 'required|min:0',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // esto es para que la imagen sea opcional y que solo acepte imagenes
        ]); 
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('products', 'public');// esto es para guardar la imagen en la carpeta public/products
            $validated['image'] = $imagePath;
        }
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category' => $validated['category'],
        ]);
        if(!$product){
            return response()->json(['product' => 'error'], 500);
        }
        return response()->json(['product' => $product], 201);
    }


    public function show($id){ // este metodo se usa para obtener un producto en especifico
        $product = Product::find($id);
        if($product){
            return response()->json(['product' => $product], 200);
        }
        return response()->json(['message' => 'Product not found'], 404);
    }
    public function update(Request $request,$id){
        $product = Product::find($id);
        if(!$product){
            return response()->json(['message' => 'Product not found'], 404);
        }
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|min:0',
            'stock' => 'required|min:0',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($product->image) {
                \Storage::disk('public')->delete($product->image);
            }
    
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }
        $product->update($validated);// actualizar el producto
        return response()->json(['product' => $product], 200);
    }


    public function destroy($id){
        $product = Product::find($id);
        if(!$product){
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted'], 200);
    }
}
