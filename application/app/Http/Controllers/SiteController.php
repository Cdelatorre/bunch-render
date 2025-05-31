<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\Product;
use App\Models\Services;
use App\Models\CategoryProduct;
use App\Models\ServiceProduct;
use App\Models\Image;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\ViewedHistory;
use App\Models\SearchHistory;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\NewLinkAdded;

class SiteController extends Controller
{
    public function index(){
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        $pageTitle = 'Home';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','/')->first();

        return view($this->activeTemplate . '.home', compact('pageTitle','sections'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . '.pages', compact('pageTitle','sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . '.contact', compact('pageTitle'));
    }


    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if(!verifyCaptcha()){
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id)
    {
        $policy = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . '.policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function allBlog()
    {
        $pageTitle = 'Blog';
        $blogs = Frontend::where('data_keys', 'blog.element')->orderBy('id', 'desc')->paginate(getPaginate(8));
        return view($this->activeTemplate.'.blog',compact('pageTitle', 'blogs'));
    }

    public function onBoarding()
    {
        $user = auth()->user();
        if ($user && $user->gm === 1) {
            $notify[] = ['warning', 'You already have a gym!'];
            return back()->withNotify($notify);
        }

        $pageTitle = 'OnBoarding';
        $categories = Category::where('status', 1)->get();
        $rootServices = Services::with('children')->whereNull('parent')->orWhere('parent', 0)->get();
        $countSteps = count($rootServices) + 11;

       return view($this->activeTemplate . '.onboarding', compact('pageTitle', 'categories', 'rootServices', 'countSteps'));

    }

    public function submitOnBoarding(Request $request) {
        $user = auth()->user();

        if (!$user) {
            $general = gs();
            $referUser = User::where('email', $request->email)->exists();

            if ($referUser) {
                $notify[] = ['error', 'Already registered email!'];
                return back()->withNotify($notify);
            }

            //User Create
            $user = new User();
            $user->email = strtolower(trim($request->email));
            $user->password = Hash::make($request->password);
            $user->username = trim($request->username);
            $user->address = json_encode($request->address);
            $user->status = 1;
            $user->kv = $general->kv ? 0 : 1;
            $user->ev = $general->ev ? 0 : 1;
            $user->sv = $general->sv ? 0 : 1;
            $user->ts = 0;
            $user->tv = 1;
            $user->gm = 0;
            $user->reg_step = 1;

            if ($user instanceof User) {
                $user->save();
            } else {
                $notify[] = ['error', 'User instance not found'];
                return back()->withNotify($notify);
            }
        }

        if ($user && $user->gm === 0) {
            $product            = new Product();
            $product->user_id  = $user->id;
            $product->title  = $request->title;
            $product->description  = $request->description;
            $product->category_id  = $request->categories[0];
            $product->email  = $request->email;
            $product->address = json_encode($request->address);
            $product->billing_address = json_encode($request->address);
            $product->bid_complete = 0;

            $product->google_rating = $request->google_rating;
            $product->google_review_count = $request->google_review_count;

            if ($request->has('started_at')) {
                $startedAt = \Carbon\Carbon::parse($request->started_at)->format('Y-m-d H:i:s');
            } else {
                $startedAt = now()->format('Y-m-d H:i:s');
            }

            if ($request->has('expired_at')) {
                $expiredAt = \Carbon\Carbon::parse($request->expired_at)->format('Y-m-d H:i:s');
            } else {
                $expiredAt = now()->addYear()->format('Y-m-d H:i:s');
            }

            $product->started_at = $startedAt;
            $product->expired_at = $expiredAt;

            $product->phone  = $request->phone;
            // $product->website  = $request->website;
            // $product->social_link  = $request->social_link;
            $product->call_to_action = $request->call_to_action;
            $product->latitude  = $request->latitude;
            $product->longitude  = $request->longitude;
            $product->formatted_address  = $request->formatted_address;
            $product->place_id = $request->place_id;

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
            $newRates = [];

            if (!empty($ratesData)) {
                foreach ($ratesData as $rateData) {
                    if ($rateData['title'] != null && $rateData['description'] != null && $rateData['price'] != null) {
                        $newRates[] = $rateData;
                    }
                }

                if (count($newRates) == 0) {
                    $product->price = 0;
                } else {
                    $prices = array_column($newRates, 'price');
                    $product->price = !empty($prices) ? min($prices) : 0;
                }
            } else {
                $product->price = 0;
            }

            $product->rates = json_encode($newRates);

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

            $user->gm = 1;
            if ($user instanceof User) {
                $user->save();
            } else {
                $notify[] = ['error', 'User instance not found'];
                return back()->withNotify($notify);
            }

            auth()->login($user);

            notify($user, 'ADD_CENTER_CONFIRM', [
                'product' => $product,
            ]);

            event(new NewLinkAdded());

            $notify[] = ['success', 'Gym has been created successfully'];
            return to_route('user.home')->withNotify($notify);
        }

        $notify[] = ['error', 'You can not create the Gym.'];
        return back()->withNotify($notify);
    }

    public function categoryProduct($id)
    {
        $category = Category::findOrFail($id);
        $pageTitle = 'Product of '.$category->name;
        $products = Product::with('getWishlist')->where('category_id', $category->id)->whereIn('status', [1,2])->orderBy('id', 'desc')->paginate(getPaginate(8));

        $categories = Category::where('status', 1)->inRandomOrder()->limit(8)->get();
        $rootServices = Services::with('children')->whereNull('parent')->orWhere('parent', 0)->get();

        $productMaxPrice = Product::whereIn('status', [1,2])->orderBy('price', 'desc')->first()->price;
        $productMaxPrice = intval($productMaxPrice);

        return view($this->activeTemplate.'.products',compact('pageTitle', 'products', 'categories', 'rootServices', 'productMaxPrice'));
    }

    public function allProduct($location = null)
    {
        $pageTitle = 'Browse Gyms';
        $products = [];

        if ($location) {
           $pageTitle = __('Gyms in :location', ['location' => ucfirst($location)]);
        }

        $categories = Category::where('status', 1)->orderBy('id', 'asc')->limit(8)->get();
        $rootServices = Services::with('children')->whereNull('parent')->orWhere('parent', 0)->get();

        $productMaxPrice = Product::whereIn('status', [1,2])->orderBy('price', 'desc')->first()->price;
        $productMaxPrice = intval($productMaxPrice);

        return view($this->activeTemplate.'.products',compact('pageTitle', 'products', 'categories', 'rootServices', 'productMaxPrice', 'location'));
    }

    public function fetchProductData(Request $request)
    {
        $search = $request->input('search');
        $shortBy = $request->input('sortBy');
        $categories = $request->input('categories', []);
        $services = $request->input('services', []);
        $min = $request->input('min');
        $max = $request->input('max');

        $userId = Auth::id();

        // Generate a unique hash for this combination of search parameters

        if ($userId && (count($categories) > 0 || count($services) > 0)) {
            $user = auth()->user();
            $address = json_decode($user->address, true) ?? ["locality" => ""];
            $city = $address['locality'] ?? "";

            $searchHash = md5(json_encode([
                'activities' => $categories,
                'services' => $services,
                'min_price' => $min,
                'max_price' => $max,
                'city' => $city
            ]));

            // Check if a similar search already exists
            $existingSearch = SearchHistory::where('search_hash', $searchHash)->orderBy('updated_at', 'desc')->first();
            if ($existingSearch) {
                // If it exists, just increment the search count
                if ($existingSearch->updated_at->isToday()) {
                    $existingSearch->increment('search_count');
                } else {
                    SearchHistory::create([
                        'user_id' => $userId,
                        'activities' => $categories,
                        'services' => $services,
                        'min_price' => $min,
                        'max_price' => $max,
                        'city' => $city,
                        'search_count' => 1,
                        'search_hash' => $searchHash,
                    ]);
                }
            } else {
                SearchHistory::create([
                    'user_id' => $userId,
                    'activities' => $categories,
                    'services' => $services,
                    'min_price' => $min,
                    'max_price' => $max,
                    'city' => $city,
                    'search_count' => 1,
                    'search_hash' => $searchHash,
                ]);
            }
        }

        $query = Product::with(['getWishlist', 'getCategories.category', 'user', 'productImages'])->whereIn('status', [1, 2]);

        if (!empty($categories)) {
            $query->whereHas('getCategories', function ($q) use ($categories) {
                $q->whereIn('category_id', $categories);
            });
        }

        if (!empty($services)) {
            $query->whereHas('getServices', function ($q) use ($services) {
                $q->whereIn('service_id', $services);
            });
        }

        if ($min !== null && $max !== null) {
            $query->whereBetween('price', [$min, $max]);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('formatted_address', 'LIKE', "%$search%");
            });
            // $query->orWhere(function ($q) use ($search) {
            //     $q->where('title', 'LIKE', "%$search%");
            // });
        }

        if ($shortBy) {
            if ($shortBy === 'name') {
                $query->orderBy('title', 'asc');
            } elseif ($shortBy === 'date') {
                $query->orderBy('id', 'desc');
            } elseif ($shortBy === 'price') {
                $query->orderBy('price', 'asc');
            }
        } else {
            $query->whereHas('category', function ($query) {
                $query->where('status', 1);
            });
        }

        $products = $query->get();

        $categories = Category::where('status', 1)->inRandomOrder()->limit(8)->get();
        $productMaxPrice = Product::whereIn('status', [1,2])->orderBy('price', 'desc')->first()->price;
        $productMaxPrice = intval($productMaxPrice);

        $view = View::make($this->activeTemplate .'.render_product', compact('products', 'categories', 'productMaxPrice'))->render();

        $map_products = [];

        foreach($products as $product) {
            $content = View::make($this->activeTemplate .'.render_product_map', compact('product'))->render();

            $map_products[] = [
                'id'     => $product->id,
                'latitude'     => $product->latitude,
                'longitude'     => $product->longitude,
                'title'      => $product->title,
                'content'   => $content,
            ];
        }

        $searchView = View::make($this->activeTemplate .'.render_product_search', compact('products'))->render();

        return response()->json([
            'html' => $view,
            'products' => $map_products,
            'search' => $searchView,
            'count' => count($products)
        ]);
    }

    public function productDetails($location, $slug, $id, Request $request)
    {

        $user = auth()->user();
        if ($user) {
            ViewedHistory::updateOrCreate(
                ['user_id' => $user->id, 'product_id' => $id],
                ['updated_at' => now()]
            );
        }

        $product = Product::with([
            'user',
            'productUsers.user',
            'productImages',
            'getCategories.category',
            'getServices.service'
        ])->where('id', $id)
          ->whereIn('status', [1, 2])
          ->firstOrFail();

        $googleReviews = getGoogleReviews($product->place_id);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(6)
            ->get();

        $pageTitle = $product->title;

        $reviews = Review::with('review')
            ->where('product_id', $product->id)
            ->where('merchant_id', $product->user_id)
            ->where('status', '1')
            ->get();

        $ratings = Review::where('merchant_id', $product->user_id)
            ->where('product_id', $product->id)
            ->where('status', '1')
            ->select(DB::raw('rating'), DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->pluck('total', 'rating')
            ->mapWithKeys(fn($item, $key) => [(int)$key => $item])
            ->toArray();

        $averageRating = 0.0;

        if ($product->user) {
            $totalReviews = $product->user->review_count + $product->google_review_count;
            if ($totalReviews > 0) {
                $averageRating = (
                    ($product->user->avg_review * $product->user->review_count) +
                    ($product->google_rating * $product->google_review_count)
                ) / $totalReviews;
            }
        } else {
            $totalReviews = $product->google_review_count;
            if ($totalReviews > 0) {
                $averageRating = $product->google_rating;
            }
        }

        return view($this->activeTemplate.'.product_details', compact('pageTitle', 'product', 'relatedProducts', 'reviews', 'googleReviews', 'ratings', 'averageRating'));
    }


    public function blogDetails($slug,$id){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $newBlogs = Frontend::whereNot('id',$id)->where('data_keys','blog.element')->latest()->limit(4)->get();
        $pageTitle = 'Blog Details';
        return view($this->activeTemplate.'blog_details',compact('blog','pageTitle', 'newBlogs'));
    }

    public function blogSearch(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $blogs = Frontend::where('data_keys', 'blog.element')
                            ->where('data_values->title', 'like', '%' . $searchTerm . '%')
                            ->get();

        $results = [
            'blogs' => $blogs
        ];
        return response()->json($results);
    }


    public function cookieAccept(){
        $general = gs();
        Cookie::queue('gdpr_cookie',$general->site_name , 43200);
        return back();
    }

    public function cookiePolicy(){
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys','cookie.data')->first();
        return view($this->activeTemplate.'.cookie',compact('pageTitle','cookie'));
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 255, 255, 255);
        $bgFill    = imagecolorallocate($image, 28, 35, 47);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }
}
