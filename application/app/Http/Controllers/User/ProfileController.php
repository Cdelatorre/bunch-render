<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Category;
use App\Models\Services;
use App\Models\Product;
use App\Models\Image;
use App\Models\CategoryProduct;
use App\Models\ServiceProduct;
use App\Events\NewLinkAdded;

class ProfileController extends Controller
{
    public function setting()
    {
        $pageTitle = "Profile Setting";
        $user = auth()->user();
        $product = Product::where('user_id', $user->id)->first();
        $categories = Category::where('status', 1)->get();
        $rootServices = Services::with('parent', 'children')->whereNull('parent')->orWhere('parent', 0)->get();

        $productCategories = $product->getCategories()->pluck('category_id')->toArray();
        $productServices = $product->getServices()->pluck('service_id')->toArray();

        return view($this->activeTemplate. 'user.profile_setting', compact('pageTitle','user','product','categories', 'rootServices', 'productCategories', 'productServices'));
    }

    public function rates()
    {
        $pageTitle = "Profile Rates";
        $user = auth()->user();
        $product = Product::where('user_id', $user->id)->first();

        return view($this->activeTemplate. 'user.profile_rates', compact('pageTitle','user','product'));
    }

    public function account()
    {
        $pageTitle = "Profile Account";
        $user = auth()->user();
        $product = Product::where('user_id', $user->id)->first();
        $newPassword = Hash::check($user->email, $user->password);

        return view($this->activeTemplate. 'user.profile_account', compact('pageTitle','user', 'product', 'newPassword'));
    }


    public function submitProfile(Request $request)
    {
        $request->validate([
            'categories'        => 'required|array|min:1',
            'categories.*'      => 'required',
            'services'          => 'required|array|min:1',
            'services.*'        => 'required',
            'schedules'         => 'required|array|min:1',
            'schedules.*'       => 'required',
            'images.*'          => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        $user = auth()->user();
        $id = $user->id;
        $product = Product::where('user_id', $user->id)->first();
        $product->category_id  = $request->categories[0];

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

        $notify[] = ['success', 'Gyms updated successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function submitAccount(Request $request)
    {
        $user = auth()->user();

        if ($user->gm === 0) {
            $request->validate([
                'firstname' => 'required|string',
                'lastname' => 'required|string',
            ],[
                'firstname.required'=>'First name field is required',
                'lastname.required'=>'Last name field is required'
            ]);
        } else {
            $request->validate([
                'title'             => 'required|string|max:255',
                'mobile'            => 'required|string|max:255',
                'website'           => 'required|string|max:255',
                'social_link'       => 'required|string|max:255',
                // 'short_description' => 'required|string|max:255',
                'description'       => 'required|string',
                'address'           => 'required',
                'billing_address'   => 'required',
            ]);
        }

        if ($user->gm === 0) {
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->mobile = $request->mobile;
            $user->address = json_encode($request->address);
        }

        $newPassword = Hash::check($user->email, $user->password);
        if ($newPassword) {
            $password = Hash::make($request->password);
            $user->password = $password;
        } else if ($request->current_password !== null && $request->password !== null) {
            $passwordValidation = Password::min(6);
            $general = gs();
            if ($general->secure_password) {
                $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
            }

            $this->validate($request, [
                'current_password' => 'required',
                'password' => ['required','confirmed', $passwordValidation],
            ]);
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
            } else {
                $notify[] = ['error', 'The password doesn\'t match!'];
                return back()->withNotify($notify);
            }
        }

        $user->save();

        if ($user->gm === 1) {
            $id = $user->id;
            $product = Product::where('user_id', $user->id)->first();

            $product->title = $request->title;
            $product->phone = $request->mobile;
            $product->website = $request->website;
            $product->social_link = $request->social_link;
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->address = json_encode($request->address);
            $product->billing_address = json_encode($request->billing_address);
            $product->latitude = $request->latitude;
            $product->longitude = $request->longitude;
            $product->formatted_address = $request->formatted_address;
            $product->place_id = $request->place_id;
            $product->google_rating = $request->google_rating;
            $product->google_review_count = $request->google_review_count;
            $product->save();

            event(new NewLinkAdded());
        }

        $notify[] = ['success', 'Profile has been updated successfully'];
        return back()->withNotify($notify);
    }

    public function submitRates(Request $request)
    {
        $request->validate([
            'rates'        => 'required|array|min:1',
            'rates.*'      => 'required',
        ]);

        $user = auth()->user();
        $id = $user->id;
        $product = Product::where('user_id', $user->id)->first();

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
        $product->call_to_action = $request->call_to_action;
        $product->save();

        $notify[] = ['success', 'Profile Rates has been updated successfully'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change Password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {
        $passwordValidation = Password::min(6);
        $general = gs();
        if ($general->secure_password) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required','confirmed',$passwordValidation]
        ]);

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = ['success', 'Password changes successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'The password doesn\'t match!'];
            return back()->withNotify($notify);
        }
    }
    public function profileUpdate(Request $request)
    {
        $this->validate($request, [

            'image' => ['nullable','image',new FileTypeValidate(['jpg','jpeg','png'])]
        ]);
        $user = auth()->user();
        if ($request->hasFile('image')) {
            try {
                $old = $user->image;
                $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $user->save();
        $notify[] = ['success', 'Profile image has been updated successfully'];
        return back()->withNotify($notify);
    }
}
