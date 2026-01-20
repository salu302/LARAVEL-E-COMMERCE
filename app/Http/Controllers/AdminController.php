<?php

namespace App\Http\Controllers;

use App\Models\Category;

use App\Models\Order;

use App\Models\Product;

 use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function view_category()
    {
        $data=Category::all();
        return view('admin.category',compact('data'));
    }
    public function add_category(Request $request)
    {
        $category = new Category;
        $category->category_name = $request->category;
        $category->save();

        // Set a plain session flash so the view can render a toastr message
        return redirect()->back()->with('success', 'Category Added Successfully.');
    }
    public function delete_category($id)
    {
        $data=Category::find($id);
        $data->delete();
        return redirect()->back()->with('success','Category Deleted Successfully.');
    }
    public function edit_category($id)
    {
        $data=Category::find($id);

        return view('admin.edit_category',compact('data'));
        // $data->edit();
        // return redirect()->back()->with('success','Category edit Successfully.');
    }
    public function update_category(Request $request ,$id)
    {
        $data=Category::find($id);
        $data->category_name=$request->category;
        $data->save();
        return redirect()->back()->with('success','Category Updated Successfully.');
    }

    public function add_product()
    {
        $category = Category::all();
        return view('admin.add_product',compact('category'));
    }
    public function upload_product(Request $request)
    {
        // Validate incoming request (limits file size to 20 MB)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric',
            'quantity' => 'nullable|integer',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480', // max = 20480 KB (20 MB)
        ]);

        $data = new Product;
        $data->title = $validated['title'];
        $data->description = $validated['description'];
        $data->price = $validated['price'] ?? null;
        $data->quantity = $validated['quantity'] ?? null;
        $data->category = $validated['category'];

        // Handle image upload only if present
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('products'), $imagename);
            $data->image = $imagename;
        }

        $data->save();

        return redirect()->back()->with('success', 'Product Uploaded Successfully.');
    }

    public function view_product()
    {
        $product = Product::Paginate(3);
        return view('admin.view_product',compact('product'));
    }
    public function delete_product($id)
    {
        $data=Product::find($id);
        $image_path=public_path('products/'.$data->image);
        if(file_exists($image_path))
            {
                unlink($image_path);

        }
        $data->delete();
        return redirect()->back()->with('success','Product Deleted Successfully.');
    }

    public function update_product($slug)
    {
        $data=Product::where('slug',$slug)->get()->first();

        $category= Category::all();

        return view('admin.update_page',compact('data','category'));

    }
    public function edit_product(Request $request ,$id)
    {
        $data=Product::find($id);
        $data->title=$request->title;
        $data->description=$request->description;;
        $data->price=$request->price;
        $data->title=$request->title;
        $data->title=$request->title;
        // Handle image update if a new image is provided
        $image = $request->image;

        if($image)
            {
                $imagename = time().'.'.$image->getClientOriginalExtension();
                


                $request->image->move('products',$imagename);
                $data->image=$imagename;
                $data->save();
                return redirect()->back()->with('success','Product Updated Successfully.');

        }
    }

    public function product_search(Request $request)
    {
        $search=$request->search;

        $product= Product::where('title','LIKE','%'.$search.'%')->orWhere('category','LIKE','%'.$search.'%')->paginate(3);
        return view('admin.view_product',compact('product'));
        

    }
    public function view_orders()

     {
        $data=Order::all();
        


        return view('admin.orders',compact('data')
        );
     }

     public function on_the_way($id)
     {
       $data = Order::find($id);
       $data->status='On the way';

       $data->save();
       return redirect('/view_orders');

     }

     public function delivered($id)
     {
       $data = Order::find($id);
       $data->status='Delivered';

       $data->save();
       return redirect('/view_orders');

     }

     public function print_pdf($id)
     {

        $data = Order::find($id);

         $pdf = Pdf::loadView('admin.invoice',compact('data'));
         // Allow loading remote assets (e.g., asset() URLs) so images render in the PDF
         $pdf->setOptions(['isRemoteEnabled' => true]);

         return $pdf->download('invoice.pdf');

     }

}
