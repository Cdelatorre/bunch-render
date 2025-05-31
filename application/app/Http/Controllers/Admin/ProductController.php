<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductUser;
use App\Models\Category;
use App\Models\Services;
use App\Models\Image;
use App\Models\Product;
use App\Models\Winner;
use App\Models\CategoryProduct;
use App\Models\ServiceProduct;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Exports\ProductsExport;
use App\Events\NewLinkAdded;

class ProductController extends Controller
{
    public function all(){
        $pageTitle = 'All Gyms';

        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::with('user')->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view('admin.product.index',compact('pageTitle', 'products'));
            }
        }

        $products = Product::with('user')->latest()->paginate(getPaginate(10));
        return view('admin.product.index',compact('pageTitle', 'products'));
    }

    /**
     * Export users data to Excel.
     */
    public function export()
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        return Excel::download(new ProductsExport, "products_{$timestamp}.xlsx");
    }

    public function pending()
    {
        $pageTitle = 'Pending Gyms';

        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::with('user')->where('status', 0)->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view('admin.product.index',compact('pageTitle', 'products'));
            }
        }

        $products = Product::with('user')->where('status', 0)->latest()->paginate(getPaginate(10));
        return view('admin.product.index',compact('pageTitle', 'products'));
    }
    public function live()
    {
        $pageTitle = 'Live Gyms';

        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::with('user')->where('status', 1)->where('started_at', '<', now())->where('expired_at', '>', now())->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view('admin.product.index',compact('pageTitle', 'products'));
            }
        }

        $products = Product::with('user')->where('status', 1)->where('started_at', '<', now())->where('expired_at', '>', now())->latest()->paginate(getPaginate(10));
        return view('admin.product.index',compact('pageTitle', 'products'));
    }
    public function upcomming()
    {
        $pageTitle = 'Upcomming Gyms';

        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::with('user')->where('status', 1)->where('started_at', '>', now())->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view('admin.product.index',compact('pageTitle', 'products'));
            }
        }

        $products = Product::with('user')->where('status', 1)->where('started_at', '>', now())->latest()->paginate(getPaginate(10));
        return view('admin.product.index',compact('pageTitle', 'products'));
    }
    public function expired()
    {
        $pageTitle = 'Expired Gyms';

        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::with('user')->where('status', 2)->where('expired_at', '<', now())->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view('admin.product.index',compact('pageTitle', 'products'));
            }
        }

        $products = Product::with('user')->where('status', 2)->where('expired_at', '<', now())->latest()->paginate(getPaginate(10));
        return view('admin.product.index',compact('pageTitle', 'products'));
    }

    public function cancel()
    {
        $pageTitle = 'Cancelled Gyms';

        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::with('user')->where('status', 3)->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view('admin.product.index',compact('pageTitle', 'products'));
            }
        }

        $products = Product::with('user')->where('status', 3)->latest()->paginate(getPaginate(10));
        return view('admin.product.index',compact('pageTitle', 'products'));
    }

    public function removeProduct($id) {
        $product = Product::findOrFail($id);
        $product->delete();

        if($product->user_id != 0)
        {
            $owner = User::findOrFail($product->user_id);
            $owner->gm = 0;
            $owner->save();
        }

        event(new NewLinkAdded());
        $notify[] = ['success', 'Product removed successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function approve(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->status = 1;
        $product->save();

        event(new NewLinkAdded());
        $notify[] = ['success', 'Product Approved Successfully'];
        return back()->withNotify($notify);
    }
    public function reject(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'message' => 'required'
        ]);
        $product = Product::findOrFail($request->id);
        $product->status = 3;
        $product->reason = $request->message;
        $product->save();

        event(new NewLinkAdded());
        $notify[] = ['success', 'Product Cancelled Successfully'];
        return back()->withNotify($notify);
    }

    public function create()
    {
        $pageTitle = 'Create Gyms';
        $categories = Category::where('status', 1)->get();
        $rootServices = Services::with('children')->whereNull('parent')->orWhere('parent', 0)->get();

        return view('admin.product.create', compact('pageTitle', 'categories', 'rootServices'));
    }

    public function edit($id)
    {
        $categories = Category::where('status', 1)->get();
        $product = Product::findOrFail($id);
        $pageTitle = 'Edit Gyms ' .'"'. $product->title . '"';
        $rootServices = Services::with('children')->whereNull('parent')->orWhere('parent', 0)->get();

        $productCategories = $product->getCategories()->pluck('category_id')->toArray();
        $productServices = $product->getServices()->pluck('service_id')->toArray();

        return view('admin.product.edit', compact('pageTitle', 'categories', 'product', 'rootServices', 'productCategories', 'productServices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'categories'        => 'required|array|min:1',
            'categories.*'      => 'required',
            'services'          => 'required|array|min:1',
            'services.*'        => 'required',
            'email'             => 'required|string|email|max:255|unique:products,email',
            'phone'             => 'required|string|max:255',
            'website'           => 'required|string|max:255',
            'social_link'       => 'required|string|max:255',
            'started_at'        => ['required_if:schedule,1'],
            'expired_at'        => ['required'],
            // 'short_description' => 'required|string',
            'description'       => 'required|string',
            'schedules'         => 'required|array|min:1',
            'schedules.*'       => 'required',
            'address'           => 'required',
            'billing_address'   => 'required',
            'rates'             => 'required|array|min:1',
            'rates.*'           => 'required',
            // 'specification'     => 'required|array|min:1',
            // 'specification.*'   => 'required',
            'images.*'          => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        $product            = new Product();
        $product->title  = $request->title;
        $product->category_id  = $request->categories[0];
        $product->email  = $request->email;
        $product->phone  = $request->phone;
        $product->website  = $request->website;
        $product->social_link  = $request->social_link;
        $product->call_to_action = $request->call_to_action;
        $product->bid_complete = 0;
        $product->latitude  = $request->latitude;
        $product->longitude  = $request->longitude;
        $product->formatted_address  = $request->formatted_address;
        $product->place_id = $request->place_id;
        $product->google_rating = $request->google_rating;
        $product->google_review_count = $request->google_review_count;

        if ($request->has('started_at')) {
            $startedAt = \Carbon\Carbon::parse($request->started_at)->format('Y-m-d H:i:s');
        } else {
            $startedAt = now()->format('Y-m-d H:i:s');
        }

        if ($request->has('expired_at')) {
            $expiredAt = \Carbon\Carbon::parse($request->expired_at)->format('Y-m-d H:i:s');
        }

        $product->started_at = $startedAt;
        $product->expired_at = $expiredAt;

        $product->address = json_encode($request->address);
        $product->billing_address = json_encode($request->billing_address);

        $product->short_description = $request->short_description;
        $product->description = $request->description;

        $schedulesData = $request->input('schedules');

        if (!empty($schedulesData)) {
            foreach ($schedulesData as $scheduleData) {
                if ($scheduleData['name'] == null && $scheduleData['start_time'] == null && $scheduleData['end_time'] == null) {
                    $notify[] = ['error', 'Schedules are empty'];
                    return redirect()->back()->withNotify($notify);
                }
            }
        }

        $product->schedules = json_encode($schedulesData);

        $ratesData = $request->input('rates');

        if (!empty($ratesData)) {
            foreach ($ratesData as $rateData) {
                if ($rateData['title'] == null && $rateData['description'] == null && $rateData['price'] == null) {
                    $notify[] = ['error', 'Rates are empty'];
                    return redirect()->back()->withNotify($notify);
                }
            }

            $prices = array_column($ratesData, 'price');
            $product->price = !empty($prices) ? min($prices) : 0;
        }

        $product->rates = json_encode($ratesData);

        $specificationData = $request->input('specification');

        if (!empty($specificationData)) {
            foreach ($specificationData as $data) {
                if ($data['name'] == null &&  $data['value'] == null) {
                    $notify[] = ['error', 'Specification are empty'];
                    return redirect()->back()->withNotify($notify);
                }
            }
        }

        $product->specification = json_encode($specificationData);

        $product->status    = 1;
        $product->save();

        if($request->categories){
            foreach($request->categories as $category)
            {
                $newCategory           = new CategoryProduct();
                $newCategory->product_id = $product->id;
                $newCategory->category_id = $category;
                $newCategory->save();
            }
        }

        if($request->services){
            foreach($request->services as $service)
            {
                $newService           = new ServiceProduct();
                $newService->product_id = $product->id;
                $newService->service_id = $service;
                $newService->save();
            }
        }

        if($request->images){
            foreach($request->images as $image)
            {
                $newImage           = new Image();
                $newImage->product_id = $product->id;
                try {
                    $directory = date("Y")."/".date("m");
                    $path       = getFilePath('product').'/'.$directory;
                    $image = fileUploader($image, $path,getFileSize('product'));
                    $newImage->image = $image;
                    $newImage->path = $directory;
                } catch (\Exception $exp) {
                    $notify[]       = ['error', 'Couldn\'t upload your image'];
                    return back()->withNotify($notify);
                }
                $newImage->save();
            }
        }

        event(new NewLinkAdded());
        $notify[] = ['success', 'Gyms created successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function delete(Request $request)
    {
        $image = Image::find($request->id);

        $check = Image::where('product_id', $image->product_id)->count();
        if($check <= 1)
        {
            $notify[] = ['error', 'You can\'t delete all image'];
            return redirect()->back()->withNotify($notify);
        }

        $path                   = getFilePath('product');
        fileManager()->removeFile($path . '/' . $image->path . '/' . $image->image);
        $image->delete();

        event(new NewLinkAdded());
        $notify[] = ['success', 'Image deleted successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'categories'        => 'required|array|min:1',
            'categories.*'      => 'required',
            'services'          => 'required|array|min:1',
            'services.*'        => 'required',
            'email'             => 'required|string|email|max:255',
            'phone'             => 'required|string|max:255',
            'website'           => 'required|string|max:255',
            'social_link'       => 'required|string|max:255',
            'started_at'        => ['required_if:schedule,1'],
            'expired_at'        => ['required'],
            // 'short_description' => 'required|string',
            'description'       => 'required|string',
            'schedules'         => 'required|array|min:1',
            'schedules.*'       => 'required',
            'address'           => 'required',
            'billing_address'   => 'required',
            'rates'             => 'required|array|min:1',
            'rates.*'           => 'required',
            // 'specification'     => 'required|array|min:1',
            // 'specification.*'   => 'required',
            'images.*'          => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        $product                = Product::findOrFail($id);
        $product->title  = $request->title;
        $product->category_id  = $request->categories[0];
        $product->email  = $request->email;
        $product->phone  = $request->phone;
        $product->website  = $request->website;
        $product->social_link  = $request->social_link;
        $product->call_to_action = $request->call_to_action;
        $product->bid_complete = 0;
        $product->latitude  = $request->latitude;
        $product->longitude  = $request->longitude;
        $product->formatted_address  = $request->formatted_address;
        $product->place_id = $request->place_id;
        $product->google_rating = $request->google_rating;
        $product->google_review_count = $request->google_review_count;

        if ($request->has('started_at')) {
            $startedAt = \Carbon\Carbon::parse($request->started_at)->format('Y-m-d H:i:s');
            $product->started_at = $startedAt;
        } else {
            $startedAt = now()->format('Y-m-d H:i:s');
            $product->started_at = $startedAt;
        }

        if ($request->has('expired_at')) {
            $expiredAt = \Carbon\Carbon::parse($request->expired_at)->format('Y-m-d H:i:s');
            $product->expired_at = $expiredAt;
        }

        $product->address = json_encode($request->address);
        $product->billing_address = json_encode($request->billing_address);

        $product->short_description = $request->short_description;
        $product->description = $request->description;

        $schedulesData = $request->input('schedules');

        if (!empty($schedulesData)) {
            foreach ($schedulesData as $scheduleData) {
                if ($scheduleData['name'] == null && $scheduleData['start_time'] == null && $scheduleData['end_time'] == null) {
                    $notify[] = ['error', 'Schedules are empty'];
                    return redirect()->back()->withNotify($notify);
                }
            }
        }

        $product->schedules = json_encode($schedulesData);

        $ratesData = $request->input('rates');

        if (!empty($ratesData)) {
            foreach ($ratesData as $rateData) {
                if ($rateData['title'] == null && $rateData['description'] == null && $rateData['price'] == null) {
                    $notify[] = ['error', 'Rates are empty'];
                    return redirect()->back()->withNotify($notify);
                }
            }

            $prices = array_column($ratesData, 'price');
            $product->price = !empty($prices) ? min($prices) : 0;
        }

        $product->rates = json_encode($ratesData);

        $specificationData = $request->input('specification');

        if (!empty($specificationData)) {
            foreach ($specificationData as $data) {
                if ($data['name'] == null &&  $data['value'] == null) {
                    $notify[] = ['error', 'Specification are empty'];
                    return redirect()->back()->withNotify($notify);
                }

            }
        }

        $product->specification = json_encode($specificationData);

        $product->status    = 1;
        $product->save();

        // Remove existing categories and services

        // Add new categories
        if($request->categories){
            $product->getCategories()->delete();

            foreach($request->categories as $category)
            {
                $newCategory           = new CategoryProduct();
                $newCategory->product_id = $product->id;
                $newCategory->category_id = $category;
                $newCategory->save();
            }
        }

        // Add new services
        if($request->services){
            $product->getServices()->delete();

            foreach($request->services as $service)
            {
                $newService           = new ServiceProduct();
                $newService->product_id = $product->id;
                $newService->service_id = $service;
                $newService->save();
            }
        }

        if($request->images){
            foreach($request->images as $image)
            {
                $newImage           = new Image();
                $newImage->product_id = $product->id;
                try {
                    $directory = date("Y")."/".date("m");
                    $path       = getFilePath('product').'/'.$directory;
                    $image = fileUploader($image, $path,getFileSize('product'));

                    $newImage->image = $image;
                    $newImage->path = $directory;
                } catch (\Exception $exp) {
                    $notify[]       = ['error', 'Couldn\'t upload your image'];
                    return back()->withNotify($notify);
                }
                $newImage->save();
            }
        }

        event(new NewLinkAdded());
        $notify[] = ['success', 'Gyms updated successfully'];
        return redirect()->back()->withNotify($notify);
    }


    public function productUsers($id)
    {
        $product = Product::findOrFail($id);
        $pageTitle = $product->name.' Users';
        $productUsers = ProductUser::where('product_id', $id)->with(['user','product.user', 'product'])->latest()->paginate(getPaginate());
        return view('admin.product.users_list', compact('pageTitle', 'productUsers', 'product'));
    }

    public function userWinner(Request $request)
    {
        $request->validate([
            'bid_id' => 'required'
        ]);

        $productUser = ProductUser::with('user', 'product')->findOrFail($request->bid_id);
        $product = $productUser->product;
        $winner = Winner::where('product_id', $product->id)->exists();

        if($winner){
            $notify[] = ['error', 'Winner for this product is already selected'];
            return back()->withNotify($notify);
        }

        if($product->expired_at > now()){
            $notify[] = ['error', 'This product is not expired till now'];
            return back()->withNotify($notify);
        }

        $user = $productUser->user;
        $general = gs();

        $winner = new Winner();
        $winner->user_id = $user->id;
        $winner->product_id = $product->id;
        $winner->bid_id = $productUser->id;
        $winner->save();

        notify($user, 'BID_WINNER', [
            'product' => $product->name,
            'product_price' => showAmount($product->price),
            'currency' => $general->cur_text,
            'amount' => showAmount($productUser->amount),
        ]);

        $notify[] = ['success', 'Winner selected successfully'];
        return back()->withNotify($notify);
    }

    public function winners(){
        $pageTitle = 'All Winners';
        $winners = Winner::with('getProduct', 'getUser', 'getUser')->latest()->paginate(getPaginate());
        return view('admin.product.winners', compact('pageTitle', 'winners'));
    }

    public function deliveredProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);


        $winner = Winner::findOrFail($request->id);
        if($winner->status == 1)
        {
            $notify[] = ['error', 'Product already delivered'];
            return back()->withNotify($notify);
        }
        $winner->status = 1;

        $winner->save();

        $notify[] = ['success', 'Product mark as delivered'];
        return back()->withNotify($notify);

    }
}
