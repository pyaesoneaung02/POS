<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    //Create Page
    public function createPage()
    {
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        $categories = Category::get();
        return view('admin.products.productPage', compact('categories','pending_order'));
    }
    //Create Process
    public function createProcess(Request $request)
    {
        $this->productValidation($request, 'create');
        $data = $this->productData($request);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid() . $file->getClientOriginalName();
            $file->move(public_path() . '/admin/product', $fileName);
            $data['image'] = $fileName;
        }
        Product::create($data);
        Alert::success('Successfully', 'Product create is successfully!');
        return back();
    }


    //View Page
    public function viewPage($slt5 = '')
    {
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        $productCount = count(Product::select('products.id')->get());
        $products = Product::select('categories.name as category_name', 'products.image', 'products.name', 'products.price', 'products.description', 'products.stock', 'products.id')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(['products.name', 'products.price', 'products.description', 'categories.name', 'products.stock'], 'like', "%" . request('searchKey') . "%");
            });
        if ($slt5 == 'stock-less-than-5') {
            $products = $products->where("stock", "<", 5);
        }
        $products = $products->orderBy('products.created_at', 'desc')
            ->paginate(4);
        return view('admin.products.productViewPage', compact('products','productCount','pending_order'));
    }

    //Product update
    public function productUpdatePage($id)
    {
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        $product = Product::where('id', $id)->first();
        $categories = Category::get();
        return view('admin.products.update', compact('product', 'categories','pending_order'));
    }

    public function productUpdateProcess(Request $request)
    {
        $this->productValidation($request, 'update');
        $productData = $this->productData($request);

        if ($request->hasFile('image')) {
            if (file_exists(public_path('admin/product/' . $request->oldImage))) {
                unlink(public_path('admin/product/' . $request->oldImage));
            }
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path() . '/admin/product', $fileName);
            $productData['image'] = $fileName;
        } else {
            $productData['image'] = $request->oldImage;
        }

        Product::find($request->productId)->update($productData);
        Alert::success('Successfully', 'Product Update is successfully!');
        return to_route('product#viewProduct');
    }

    //delete route
    public function productDelete($id)
    {
        if (file_exists(public_path('admin/product/' . request("oldImage")))) {
            unlink(public_path('admin/product/' . request("oldImage")));
        }
        Product::find($id)->delete();
        Alert::success('Successfully', 'Product Delete is successfully!');
        return to_route('product#viewProduct');
    }

    //detail page
    public function productDetail($id)
    {
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        $product = Product::leftJoin('categories', 'products.category_id', 'categories.id')
            ->select('categories.name as category_name', 'products.image', 'products.name', 'products.price', 'products.description', 'products.stock', 'products.id', 'products.created_at', 'products.updated_at')
            ->where('products.id', $id)
            ->first();
        return view('admin.products.detail', compact('product','pending_order'));
    }

    //private Function
    //product data
    private function productData($request)
    {
        return [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->categoryId,
            'stock' => $request->stock,
        ];
    }

    //product validation
    private function productValidation($request, $action)
    {
        $validationRule = [
            'name' => 'required|unique:products,name,' . $request->productId,
            'categoryId' => 'required',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|max:999',
            'description' => 'required|max:2000'
        ];
        $validationRule['image'] = $action == 'create' ? 'required|mimes:jpg,jpeg,png,bmp,svg|file' : 'mimes:jpg,jpeg,png,bmp,svg|file';
        $request->validate($validationRule);
    }
}
