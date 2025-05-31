<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ProductUser;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Winner;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use App\Events\NewLinkAdded;

class ProductController extends Controller
{
    public function all(){
        $pageTitle = 'All Gyms';
        $user = auth()->user();
        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::where('user_id', $user->id)->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view($this->activeTemplate . 'user.product.index',compact('pageTitle', 'products'));
            }
        }

        $products = Product::where('user_id', $user->id)->latest()->paginate(getPaginate(10));
        return view($this->activeTemplate . 'user.product.index',compact('pageTitle', 'products'));
    }

    public function pending()
    {
        $pageTitle = 'Pending Gyms';
        $user = auth()->user();
        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::where('user_id', $user->id)->where('status', 0)->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view($this->activeTemplate . 'user.product.index',compact('pageTitle', 'products'));
            }

        }

        $products = Product::where('user_id', $user->id)->where('status', 0)->latest()->paginate(getPaginate(10));
        return view($this->activeTemplate . 'user.product.index',compact('pageTitle', 'products'));
    }
    public function live()
    {
        $pageTitle = 'Live Gyms';
        $user = auth()->user();
        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::where('user_id', $user->id)->where('status', 1)->where('started_at', '<', now())->where('expired_at', '>', now())->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view($this->activeTemplate . 'user.product.index',compact('pageTitle', 'products'));
            }

        }

        $products = Product::where('user_id', $user->id)->where('status', 1)->where('started_at', '<', now())->where('expired_at', '>', now())->latest()->paginate(getPaginate(10));
        return view($this->activeTemplate . 'user.product.index',compact('pageTitle', 'products'));
    }
    public function upcomming()
    {
        $pageTitle = 'Upcomming Gyms';
        $user = auth()->user();
        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::where('user_id', $user->id)->where('status', 1)->where('started_at', '>', now())->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view($this->activeTemplate . 'user.product.index',compact('pageTitle', 'products'));
            }

        }

        $products = Product::where('user_id', $user->id)->where('status', 1)->where('started_at', '>', now())->latest()->paginate(getPaginate(10));
        return view($this->activeTemplate . 'user.product.index',compact('pageTitle', 'products'));
    }
    public function expired()
    {
        $pageTitle = 'Expired Gyms';
        $user = auth()->user();
        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::where('user_id', $user->id)->where('status', 2)->where('expired_at', '<', now())->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view($this->activeTemplate . 'user.product.index',compact('pageTitle', 'products'));
            }

        }

        $products = Product::where('user_id', $user->id)->where('status', 2)->where('expired_at', '<', now())->latest()->paginate(getPaginate(10));
        return view($this->activeTemplate . 'user.product.index',compact('pageTitle', 'products'));
    }

    public function cancel()
    {
        $pageTitle = 'Cancelled Gyms';
        $user = auth()->user();
        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::where('user_id', $user->id)->where('status', 3)->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view($this->activeTemplate . 'user.product.index',compact('pageTitle', 'products'));
            }

        }

        $products = Product::where('user_id', $user->id)->where('status', 3)->latest()->paginate(getPaginate(10));
        return view($this->activeTemplate . 'user.product.index',compact('pageTitle', 'products'));
    }


    public function create()
    {
        $pageTitle = 'Create Gyms';
        $categories = Category::where('status', 1)->get();

        return view($this->activeTemplate . 'user.product.create', compact('pageTitle', 'categories'));
    }

    public function edit($id)
    {
        $categories = Category::where('status', 1)->get();
        $product = Product::findOrFail($id);
        $user = auth()->user();
        if($product->user_id != $user->id)
        {
            $notify[] = ['error', 'Request product not found.'];
            return redirect()->back()->withNotify($notify);
        }
        $pageTitle = 'Edit Gyms ' .'"'. $product->title . '"';
        return view($this->activeTemplate . 'user.product.edit', compact('pageTitle', 'categories', 'product'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title'              => 'required|string|max:255',
            'category'          => 'required|exists:categories,id',
            'price'             => 'required|numeric|gt:0',
            'started_at'        => ['required_if:schedule,1','date','after:yesterday','before:expired_at'],
            'expired_at'        => ['required'],
            // 'short_description' => 'required|string',
            'description'       => 'required|string',
            'specification'       => 'required|array|min:1',
            'specification.*'       => 'required',
            'images.*'          => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);


        $user = auth()->user(); // TODO
        $product            = new Product();
        $product->title  = $request->title;
        $product->user_id = 1; // $user->id;
        $product->category_id  = $request->category;
        $product->price = $request->price;
        $product->bid_complete = 0;
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


        $product->short_description = $request->short_description;
        $product->description = $request->description;

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


        $product->status    = 0;
        $product->save();

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
        return to_route('user.product.index')->withNotify($notify);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title'              => 'required|string|max:255',
            'category'          => 'required|exists:categories,id',
            'price'             => 'required|numeric|gt:0',
            'started_at'        => ['required_if:schedule,1','date','after:yesterday','before:expired_at'],
            'expired_at'        => ['required'],
            'short_description' => 'required|string',
            'description'       => 'required|string',
            'specification'       => 'required|array|min:1',
            'specification.*'       => 'required',
            'image'          => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        $user = auth()->user();
        $product                = Product::findOrFail($id);
        if($user->id != $product->user_id)
        {
            $notify[]       = ['error', 'You are not authorized to update'];
            return back()->withNotify($notify);
        }

        if($product->status == 1)
        {
            $notify[]       = ['error', 'This product is already live and cannot be updated'];
            return back()->withNotify($notify);
        }
        if($product->status == 3 || $product->status == 2)
        {
            $notify[]       = ['error', 'Your product submission has been declined. Please create a new product for resubmission.'];
            return back()->withNotify($notify);
        }


        if($product->status == 0)
        {
            $product->title         = $request->title;
            $product->category_id   = $request->category;
            $product->price         = $request->price;
            $product->bid_complete  = 0;
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


            $product->short_description = $request->short_description;
            $product->description = $request->description;

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


            $product->save();

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
            return to_route('user.product.index')->withNotify($notify);
        }else{
            $notify[] = ['error', 'The bidding process for this product has concluded, and updates are no longer possible.'];
            return back()->withNotify($notify);
        }

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



    public function productUsers($id)
    {
        $product = Product::findOrFail($id);
        $pageTitle = $product->name.' Request List';
        $productUsers = ProductUser::where('product_id', $id)->with('user','product.user', 'product')->latest()->paginate(getPaginate(10));
        return view($this->activeTemplate . 'user.product.users_list', compact('pageTitle', 'productUsers', 'product'));
    }


    public function winners(){
        $pageTitle = 'All Winners';
        $winners = Winner::with('getProduct', 'getProduct.user', 'getUser')->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.product.winners', compact('pageTitle', 'winners'));
    }
}
