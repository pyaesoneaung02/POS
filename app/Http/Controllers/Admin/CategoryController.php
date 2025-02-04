<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    //public routes .......................///
    //list page
    public function list()
    {
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        $categories = Category::orderByDesc('created_at')->paginate(4);
        return view("admin.category.categoryPage", compact('categories','pending_order'));
    }

    //create
    public function create(Request $request)
    {
        $this->validation($request);
        Category::create(
            [
                'name' => $request->categoryName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        Alert::success('Create', 'Create Category Name!');
        return back();
    }
    //update Page
    public function updatePage($id)
    {
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        $category = Category::find($id);
        return view('admin.update.updatePage', compact('category','pending_order'));
    }
    //update Process
    public function updateProcess($id, Request $request)
    {
        $this->validation($request);
        $updateData = ['name' => $request->categoryName, 'updated_at' => Carbon::now()];
        Category::find($id)->update($updateData);
        Alert::success('Update', 'Update Category Name is Successfully!');
        return to_route('category#list');
    }

    //delete Process
    public function deleteProcess($id){
        Category::find($id)->delete();
        Alert::success('Delete', 'Deleting Category Name is Successfully!');
        return to_route('category#list');
    }

    //private routes......................///

    //validation function
    private function validation($request)
    {
        $validationRule = [
            "categoryName" => 'required'
        ];
        $validationMessage = [
            'categoryName.required' => 'အမျိုးအစားအမည် ဖြည့်စွက်ရန် လိုအပ်သည်။'
        ];
        $request->validate($validationRule, $validationMessage);
    }
}
