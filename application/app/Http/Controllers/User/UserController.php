<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use App\Models\ProductUser;
use App\Models\Form;
use App\Models\Product;
use App\Models\Review;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\SearchHistory;
use App\Models\Category;
use App\Models\Services;
use App\Models\ViewedHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function home()
    {
        $pageTitle = 'Dashboard';
        $user = auth()->user();

        if ($user->gm === 0) {
            $wishlists = Wishlist::with('getProduct', 'getProduct.productImages', 'getProduct.getWishlist', 'getProduct.getCategories.category', 'getProduct.user')->where('user_id', $user->id)->orderBy('id','desc')->get();

            $reviews = Review::with('review')->where('user_id', $user->id)->get();

            $viewedHistory = ViewedHistory::where('user_id', $user->id)->count();

            $visits = ProductUser::where('user_id', $user->id)
                ->where('visit_time', '<', now())
                ->count();

            $todayVisits = ProductUser::where('user_id', $user->id)
                ->whereDate('visit_time', now()->toDateString())
                ->count();

            $address = json_decode($user->address, true) ?? ["locality" => ""];
            $city = $address['locality'] ?? "";

            $mostHistory = SearchHistory::selectRaw("
                    sh.user_id,
                    JSON_UNQUOTE(json_extract(activity_data.activity, '$')) AS activity,
                    SUM(sh.search_count) AS total_searches
                ")
                ->whereNotNull('sh.user_id')
                // ->where('user_id', $user->id)
                ->where('city', $city)
                ->from('search_histories as sh')
                ->join(DB::raw("JSON_TABLE(sh.activities, '$[*]' COLUMNS (activity VARCHAR(255) PATH '$')) AS activity_data"), function($join) {
                    $join->whereNotNull('sh.user_id');
                })
                ->groupBy('activity', 'sh.user_id')
                ->orderBy('total_searches', 'desc')
                ->limit(1)
                ->get()
                ->groupBy('user_id')
                ->map(function ($activities) {
                    return $activities->map(function ($activity) {
                        return [
                            'activity' => $activity->activity,
                            'total_searches' => $activity->total_searches,
                        ];
                    });
                });

            $mostSearchedActivity = null;
            if ($mostHistory->count()) {
                $mostHistory = $mostHistory->first()->toArray();
                $topActivityId = $mostHistory[0]['activity'];
                $category = Category::findOrFail($topActivityId);
                $mostSearchedActivity = $category;
            }

            return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'wishlists', 'reviews', 'viewedHistory', 'mostSearchedActivity', 'visits', 'todayVisits'));
        } else {
            $product = Product::with('user')->where('user_id', $user->id)->get()->first();
            $productId = $product->id;

            $stats = $this->fetchWeekStats($productId);
            $visits = $this->fetchWeekVisits($productId);
            $trends = $this->getTrendsByDateRange(6);
            $upcomingVisits = $this->fetchUpcomingVisits($productId);
            $googleReviews = getGoogleReviews($product->place_id);

            $address = json_decode($user->address, true) ?? ["locality" => ""];
            $city = $address['locality'] ?? "";


            $mostHistory = $this->getTrendsByDateRange(29);

            $mostHistory = SearchHistory::selectRaw("
                    sh.user_id,
                    JSON_UNQUOTE(json_extract(activity_data.activity, '$')) AS activity,
                    SUM(sh.search_count) AS total_searches
                ")
                ->whereNotNull('sh.user_id')
                // ->where('user_id', $user->id)
                ->where('city', $city)
                ->from('search_histories as sh')
                ->join(DB::raw("JSON_TABLE(sh.activities, '$[*]' COLUMNS (activity VARCHAR(255) PATH '$')) AS activity_data"), function($join) {
                    $join->whereNotNull('sh.user_id');
                })
                ->groupBy('activity', 'sh.user_id')
                ->orderBy('total_searches', 'desc')
                ->limit(1)
                ->get()
                ->groupBy('user_id')
                ->map(function ($activities) {
                    return $activities->map(function ($activity) {
                        return [
                            'activity' => $activity->activity,
                            'total_searches' => $activity->total_searches,
                        ];
                    });
                });


            $mostSearchedActivity = null;
            if ($mostHistory->count()) {
                $mostHistory = $mostHistory->first()->toArray();
                $topActivityId = $mostHistory[0]['activity'];
                $category = Category::findOrFail($topActivityId);
                $mostSearchedActivity = $category;
            }

            $reviews = Review::where('merchant_id', $user->id)
                ->whereStatus('1')
                ->select(
                    DB::raw('rating'),
                    DB::raw('count(*) as total')
                )
                ->groupBy('rating')
                ->pluck('total', 'rating')
                ->mapWithKeys(function ($item, $key) {
                    return [(int)$key => $item];
                })
                ->toArray();

            $reviews = array_replace([1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0], $reviews);

            return view($this->activeTemplate . 'user.gym_dashboard', compact('pageTitle', 'stats', 'visits', 'upcomingVisits', 'user', 'product', 'reviews', 'googleReviews', 'trends', 'mostSearchedActivity', 'visits'));
        }
    }

    public function getTrendsByDateRange($dateRange) {
        $startDate = Carbon::now()->subDays($dateRange)->startOfDay();

        $trendsResult = SearchHistory::selectRaw("
                JSON_UNQUOTE(json_extract(service_data.service, '$')) AS service,
                SUM(sh.search_count) AS total_searches
            ")
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->whereNotNull('sh.user_id')
            ->from('search_histories as sh')
            ->join(DB::raw("JSON_TABLE(sh.services, '$[*]' COLUMNS (service VARCHAR(255) PATH '$')) AS service_data"), function($join) {
                $join->whereNotNull('sh.user_id');
            })
            ->groupBy('service')
            ->orderBy('total_searches', 'desc')
            ->limit(5)
            ->get();

        $trends = [];
        foreach ($trendsResult as $trend) {
            $category = Services::findOrFail($trend->service);

            $trends[] = [
                'title' => $category->name,
                'count' => $trend->total_searches,
            ];
        }

        return $trends;
    }

    public function fetchTrends(Request $request) {
        $type = $request->type;

        $result = [];

        switch ($type) {
            case 'week':
                $result = $this->getTrendsByDateRange(6);
                break;
            case 'month':
                $result = $this->getTrendsByDateRange(29);
                break;
            case 'year':
                $result = $this->getTrendsByDateRange(365);
                break;
            case 'all':
                $result = $this->getTrendsByDateRange(36500);
                break;
            default:
                $result = ['error' => 'Invalid type'];
            break;
        }

        return response()->json($result);
    }

    // GYM Stats
    public function processStatsData($dateRange, $viewsData, $reviewsData, $requestsData, $favoritesData) {
        $views = [];
        $reviews = [];
        $requests = [];
        $favorites = [];

        $totalViews = 0;
        $totalReviews = 0;
        $totalRequests = 0;
        $totalFavorites = 0;

        foreach ($dateRange as $date) {
            if (isset($viewsData[$date])) {
                $views[] = $viewsData[$date]->count;
                $totalViews += (int) $viewsData[$date]->count;
            } else {
                $views[] = 0;
            }

            if (isset($reviewsData[$date])) {
                $reviews[] = $reviewsData[$date]->count;
                $totalReviews += (int) $reviewsData[$date]->count;
            } else {
                $reviews[] = 0;
            }

            if (isset($requestsData[$date])) {
                $requests[] = $requestsData[$date]->count;
                $totalRequests += (int) $requestsData[$date]->count;
            } else {
                $requests[] = 0;
            }

            if (isset($favoritesData[$date])) {
                $favorites[] = $favoritesData[$date]->count;
                $totalFavorites += (int) $favoritesData[$date]->count;
            } else {
                $favorites[] = 0;
            }
        }

        return [
            'labels' => $dateRange,
            'series' => [
                'views' => $views,
                'reviews' => $reviews,
                'requests' => $requests,
                'favorites' => $favorites,
            ],
            'total' => [
                'views' => $totalViews,
                'reviews' => $totalReviews,
                'requests' => $totalRequests,
                'favorites' => $totalFavorites,
            ]
        ];
    }

    public function fetchAllStats($productId) {
        $user = auth()->user();

        $startYear = Carbon::now()->subYears(4)->startOfYear();
        $endYear = Carbon::now()->endOfYear();
        $dateRange = [];

        $currentYear = $startYear->copy();
        while ($currentYear->lte($endYear)) {
            $year = $currentYear->year;
            $dateRange[] = $year;
            $currentYear->addYear();
        }

        $viewsData = DB::table('viewed_histories')
            ->where('created_at', '>=', $startYear)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('product_id', $productId)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as count')
            )
            ->groupBy('year')
            ->orderBy('year')
            ->get()
            ->keyBy('year')
            ->toArray();

        $reviewsData = DB::table('reviews')
            ->where('created_at', '>=', $startYear)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('merchant_id', $user->id)
            ->whereStatus('1')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as count')
            )
            ->groupBy('year')
            ->orderBy('year')
            ->get()
            ->keyBy('year')
            ->toArray();

        $requestsData = DB::table('product_users')
            ->where('created_at', '>=', $startYear)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('product_id', $productId)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as count')
            )
            ->groupBy('year')
            ->orderBy('year')
            ->get()
            ->keyBy('year')
            ->toArray();

        $favoritesData = DB::table('wishlists')
            ->where('created_at', '>=', $startYear)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('product_id', $productId)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as count')
            )
            ->groupBy('year')
            ->orderBy('year')
            ->get()
            ->keyBy('year')
            ->toArray();

        return $this->processStatsData($dateRange, $viewsData, $reviewsData, $requestsData, $favoritesData);
    }

    public function fetchYearStats($productId) {
        $user = auth()->user();

        $startMonth = Carbon::now()->subMonths(11)->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();
        $dateRange = [];

        $currentMonth = $startMonth->copy();
        while ($currentMonth->lte($endMonth)) {
            $year = $currentMonth->year;
            $month = $currentMonth->month;
            $dateRange[] = Carbon::create($year, $month)->format('Y-m');
            $currentMonth->addMonth();
        }

        $viewsData = DB::table('viewed_histories')
            ->where('created_at', '>=', $startMonth)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('product_id', $productId)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('count(*) as count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(function ($item) {
                return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
            })
            ->toArray();

        $reviewsData = DB::table('reviews')
            ->where('created_at', '>=', $startMonth)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('merchant_id', $user->id)
            ->whereStatus('1')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('count(*) as count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(function ($item) {
                return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
            })
            ->toArray();

        $requestsData = DB::table('product_users')
            ->where('created_at', '>=', $startMonth)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('product_id', $productId)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('count(*) as count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(function ($item) {
                return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
            })
            ->toArray();

        $favoritesData = DB::table('wishlists')
            ->where('created_at', '>=', $startMonth)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('product_id', $productId)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('count(*) as count'),
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(function ($item) {
                return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
            })
            ->toArray();

        return $this->processStatsData($dateRange, $viewsData, $reviewsData, $requestsData, $favoritesData);
    }

    public function fetchMonthStats($productId) {
        $user = auth()->user();

        $startDate = Carbon::now()->subDays(29)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        $dateRange = [];

        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $dateRange[] = $currentDate->toDateString();
            $currentDate->addDay();
        }

        $viewsData = DB::table('viewed_histories')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('product_id', $productId)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();

        $reviewsData = DB::table('reviews')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('merchant_id', $user->id)
            ->whereStatus('1')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();

        $requestsData = DB::table('product_users')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('product_id', $productId)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();

        $favoritesData = DB::table('wishlists')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('product_id', $productId)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();

        return $this->processStatsData($dateRange, $viewsData, $reviewsData, $requestsData, $favoritesData);
    }

    public function fetchWeekStats($productId) {
        $user = auth()->user();

        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        $dateRange = [];

        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $dateRange[] = $currentDate->toDateString();
            $currentDate->addDay();
        }

        $viewsData = DB::table('viewed_histories')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('product_id', $productId)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();

        $reviewsData = DB::table('reviews')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('merchant_id', $user->id)
            ->whereStatus('1')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();

        $requestsData = DB::table('product_users')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('product_id', $productId)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();

        $favoritesData = DB::table('wishlists')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->where('product_id', $productId)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();

        return $this->processStatsData($dateRange, $viewsData, $reviewsData, $requestsData, $favoritesData);
    }

    public function fetchStats(Request $request) {
        $type = $request->type;

        $result = [];

        switch ($type) {
            case 'week':
                $result = $this->fetchWeekStats($request->product_id);
                break;
            case 'month':
                $result = $this->fetchMonthStats($request->product_id);
                break;
            case 'year':
                $result = $this->fetchYearStats($request->product_id);
                break;
            case 'all':
                $result = $this->fetchAllStats($request->product_id);
                break;
            default:
                $result = ['error' => 'Invalid type'];
            break;
        }

        return response()->json($result);
    }

    // GYM Visits
    public function fetchUpcomingVisits($productId) {
        $upcomingVisits = ProductUser::where('product_id', $productId)
            ->where('visit_time', '>=', Carbon::now()->toDateTimeString())
            ->with('user')
            ->orderBy('visit_time')
            ->limit(3)
            ->get();

        return $upcomingVisits;
    }

    public function processVisitsData($dateRange, $visitsData) {
        $visits = [];
        $totalVisits = 0;

        foreach ($dateRange as $date) {
            if (isset($visitsData[$date])) {
                $visits[] = $visitsData[$date]->count;
                $totalVisits += (int) $visitsData[$date]->count;
            } else {
                $visits[] = 0;
            }
        }

        return [
            'labels' => $dateRange,
            'series' => [
                'visits' => $visits,
            ],
            'total' => [
                'visits' => $totalVisits,
            ]
        ];
    }

    public function fetchAllVisits($productId) {
        $startYear = Carbon::now()->startOfYear();
        $endYear = Carbon::now()->addYears(4)->endOfYear();
        $dateRange = [];

        $currentYear = $startYear->copy();
        while ($currentYear->lte($endYear)) {
            $year = $currentYear->year;
            $dateRange[] = $year;
            $currentYear->addYear();
        }

        $visits = DB::table('product_users')
            ->where('product_id', $productId)
            ->where('visit_time', '>=', Carbon::now()->toDateTimeString())
            ->where('visit_time', '<=', $endYear)
            ->select(
                DB::raw('YEAR(visit_time) as year'),
                DB::raw('count(*) as count')
            )
            ->groupBy('year')
            ->orderBy('year')
            ->get()
            ->keyBy('year')
            ->toArray();

        return $this->processVisitsData($dateRange, $visits);
    }

    public function fetchYearVisits($productId) {
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->addMonths(11)->endOfMonth();
        $dateRange = [];

        $currentMonth = $startMonth->copy();
        while ($currentMonth->lte($endMonth)) {
            $year = $currentMonth->year;
            $month = $currentMonth->month;
            $dateRange[] = Carbon::create($year, $month)->format('Y-m');
            $currentMonth->addMonth();
        }

        $visits = DB::table('product_users')
            ->where('product_id', $productId)
            ->where('visit_time', '>=', Carbon::now()->toDateTimeString())
            ->where('visit_time', '<=', $endMonth)
            ->select(
                DB::raw('YEAR(visit_time) as year'),
                DB::raw('MONTH(visit_time) as month'),
                DB::raw('count(*) as count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(function ($item) {
                return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
            })
            ->toArray();

        return $this->processVisitsData($dateRange, $visits);
    }

    public function fetchMonthVisits($productId) {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->addDays(29)->endOfDay();

        $dateRange = [];

        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $dateRange[] = $currentDate->toDateString();
            $currentDate->addDay();
        }

        $visits = DB::table('product_users')
            ->where('product_id', $productId)
            ->where('visit_time', '>=', Carbon::now()->toDateTimeString())
            ->where('visit_time', '<=', $endDate)
            ->select(
                DB::raw('DATE(visit_time) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();

        return $this->processVisitsData($dateRange, $visits);
    }

    public function fetchWeekVisits($productId) {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->addDays(6)->endOfDay();

        $dateRange = [];

        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $dateRange[] = $currentDate->toDateString();
            $currentDate->addDay();
        }

        $visits = DB::table('product_users')
            ->where('product_id', $productId)
            ->where('visit_time', '>=', Carbon::now()->toDateTimeString())
            ->where('visit_time', '<=', $endDate)
            ->select(
                DB::raw('DATE(visit_time) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();

        return $this->processVisitsData($dateRange, $visits);
    }

    public function fetchGymVisits(Request $request) {
        $type = $request->type;

        $result = [];

        switch ($type) {
            case 'week':
                $result = $this->fetchWeekVisits($request->product_id);
                break;
            case 'month':
                $result = $this->fetchMonthVisits($request->product_id);
                break;
            case 'year':
                $result = $this->fetchYearVisits($request->product_id);
                break;
            case 'all':
                $result = $this->fetchAllVisits($request->product_id);
                break;
            default:
                $result = ['error' => 'Invalid type'];
            break;
        }

        return response()->json($result);
    }

    // User
    public function fetchVisits(Request $request) {
        $user = auth()->user();
        $month = $request->month;

        $visits = ProductUser::with('product')
            ->where('user_id', $user->id)
            ->whereMonth('visit_time', $month)
            ->get();

        $groupedVisits = [];

        foreach ($visits as $visit) {
            $date = (int) Carbon::parse($visit->visit_time)->format('d');
            $visit_time = Carbon::parse($visit->visit_time)->format('h:i A');

            if (!isset($groupedVisits[$date])) {
                $groupedVisits[$date] = [];
            }

            $address = json_decode($visit->product->address, true) ?? ["locality" => ""];
            $location = $address['locality'] ?? "-";

            $groupedVisits[$date][] = $visit->product ? [
                'title' => $visit->product->title.'('.$visit_time.')',
                'link' => getProductUrl($visit->product),
            ] : [];
        }

        return response()->json(['visits' => $groupedVisits]);
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->user()->deposits();
        if ($request->search) {
            $deposits = $deposits->where('trx',$request->search);
        }
        $deposits = $deposits->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm()
    {
        $general = gs();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->site_name, $secret);
        $pageTitle = '2FA Setting';
        return view($this->activeTemplate.'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user,$request->code,$request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions(Request $request)
    {
        $pageTitle = 'Transactions';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $transactions = Transaction::where('user_id',auth()->id());

        if ($request->search) {
            $transactions = $transactions->where('trx',$request->search);
        }

        if ($request->type) {
            $transactions = $transactions->where('trx_type',$request->type);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark',$request->remark);
        }

        $transactions = $transactions->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.transactions', compact('pageTitle','transactions','remarks'));
    }

    public function kycForm()
    {
        if (auth()->user()->kv == 2) {
            $notify[] = ['error','Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == 1) {
            $notify[] = ['error','You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form = Form::where('act','kyc')->first();
        return view($this->activeTemplate.'user.kyc.form', compact('pageTitle','form'));
    }

    public function kycData()
    {
        $user = auth()->user();
        $pageTitle = 'KYC Data';
        return view($this->activeTemplate.'user.kyc.info', compact('pageTitle','user'));
    }

    public function kycSubmit(Request $request)
    {
        $form = Form::where('act','kyc')->first();
        $formData = $form->form_data;
        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);
        $user = auth()->user();
        $user->kyc_data = $userData;
        $user->kv = 2;
        $user->save();

        $notify[] = ['success','KYC data submitted successfully'];
        return to_route('user.home')->withNotify($notify);

    }

    public function attachmentDownload($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general = gs();
        $title = slug($general->site_name).'- attachments.'.$extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData()
    {
        $info = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries = json_decode(file_get_contents(resource_path('views/includes/country.json')));
        $user = auth()->user();
        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate.'user.user_data', compact('pageTitle','user','mobileCode','countries'));
    }

    public function deleteUserData() {
        $user = auth()->user();
        $user->status = 2;
        $user->save();

        return response()->json([
            'status' => true
        ]);
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();

        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $request->validate([
            'firstname'=>'required',
            'lastname'=>'required',
        ]);

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->address = json_encode($request->address);
        $user->reg_step = 1;
        $user->kv = 1;
        $user->save();

        $notify[] = ['success','Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);

    }

    public function bid(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $user = auth()->user();

        if($user->gm == 1)
        {
            $notify[] = ['error', 'Gym can not request for a other gym'];
            return redirect()->back()->withNotify($notify);
        }

        // if($product->price  > $request->price)
        // {
        //     $notify[] = ['error', 'Your requesting price is lower then product price.'];
        //     return redirect()->back()->withNotify($notify);
        // }

        if($product->status == 0 || $product->status == 2 || $product->status == 3){
            $notify[] = ['error', 'Requesting not possible now'];
            return redirect()->back()->withNotify($notify);
        }

        if($product->user_id == $user->id)
        {
            $notify[] = ['error', 'You can not request your gym'];
            return redirect()->back()->withNotify($notify);
        }

        $visitTime = Carbon::parse($request->visit_date.' '.$request->visit_time)->toDateTimeString();
        $check = ProductUser::where('user_id', $user->id)->where('product_id', $product->id)->where('visit_time', $visitTime)->first();

        if($check)
        {
            // if(intval($check->price) >= intval($request->price))
            // {
            //     $notify[] = ['error', 'Update your request price to a higher amount to participate again.'];
            //     return redirect()->back()->withNotify($notify);
            // }

            // $updateAmount = (intval($request->price) - intval($check->price));
            // $user->balance -= $updateAmount;
            // $user->save();

            // $check->price = $request->price;
            // $check->save();

            // $transaction = new Transaction();
            // $transaction->user_id = $user->id;
            // $transaction->amount = $updateAmount;
            // $transaction->post_balance = $user->balance;
            // $transaction->charge = 0;
            // $transaction->trx_type = '-';
            // $transaction->details = 'Subtracted for updating the previous bid';
            // $transaction->trx = getTrx();
            // $transaction->remark = 'bid';
            // $transaction->save();


            $notify[] = ['info', 'You have already requested.', '', '🚀'];
            return redirect()->back()->withNotify($notify);
        }

        $productUser = new ProductUser();
        $productUser->product_id = $request->product_id;
        $productUser->user_id = $user->id;
        $productUser->product_creator_id = $product->user_id != 0 ? $product->user_id : 0;
        $productUser->price = $request->price;
        $productUser->visit_time = $visitTime;
        $productUser->save();

        $user->balance -= $request->price;
        $user->save();

        $product->bid_count += 1;
        $product->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $request->price;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type = '-';
        $transaction->details = 'Subtracted for a new bid';
        $transaction->trx = getTrx();
        $transaction->remark = 'bid';
        $transaction->save();

        if($product->user_id == 0){
            $adminNotification = new AdminNotification();
            $adminNotification->user_id = $user->id;
            $adminNotification->title = 'A user has placed a request on your gym.';
            $adminNotification->click_url = urlPath('admin.product.users.list',$product->id);
            $adminNotification->save();
        }

        notify($user, 'BOOKING_CONFIRM', [
            'product' => $product->title,
            'location' => $product->formatted_address,
            'booking_date' => $request->visit_date,
            'booking_time' => $request->visit_time,
        ]);

        $productOwner = User::findOrFail($product->user_id);
        notify($productOwner, 'BOOKING_GYM_CONFIRM', [
            'user' => $user->fullname,
            'booking_date' => $request->visit_date,
            'booking_time' => $request->visit_time,
        ]);

        $notify[] = ['success', 'Booking confirmed!', 'We have sent a copy of the reservation to your email.', '🚀'];
        return redirect()->back()->withNotify($notify);
    }

    public function requestHistory()
    {
        $user = auth()->user();
        $pageTitle = 'Requesting History';

        $product = Product::with('user')->where('user_id', $user->id)->get()->first();
        $productId = $product->id;

        $productUsers = ProductUser::with(['product', 'user', 'product.user', 'product.productImages'])->where('product_id', $productId)->orderBy('id','desc')->paginate(getPaginate());

        return view($this->activeTemplate.'user.gym_users', compact('pageTitle','productUsers'));
    }

    public function requestHistoryStore(Request $request) {
        $productUser = ProductUser::where('id', $request->id)->first();
        $productUser->status = $request->status;
        $productUser->save();

        $notify[] = ['success', 'Status successfully updated.'];
        return redirect()->back()->withNotify($notify);
    }

    public function reviewsHistory()
    {
        $user = auth()->user();
        $pageTitle = 'Reviews History';

        $product = Product::with('user')->where('user_id', $user->id)->get()->first();
        $userId = $product->user_id;
        $reviews = Review::with('review')->where('merchant_id', $userId)->orderBy('id','desc')->paginate(getPaginate());

        return view($this->activeTemplate.'user.reviews_history', compact('pageTitle','reviews'));
    }

    public function reviewsHistoryStore(Request $request) {
        $review = Review::where('id', $request->id)->first();
        $review->status = $request->status;
        $review->save();

        $user = auth()->user();
        $product = Product::with('user')->where('user_id', $user->id)->get()->first();
        $userId = $product->user_id;

        $reviews = Review::with('review')
            ->where('product_id', $product->id)
            ->where('merchant_id', $userId)
            ->where('status', '1')
            ->get();

        $total_star = $reviews->sum('rating');
        $avg_star = $reviews->count() > 0 ? $total_star / $reviews->count() : 0;

        $productOwner = User::findOrFail($userId);
        $productOwner->avg_review = $avg_star;
        $productOwner->review_count = $reviews->count();
        $productOwner->save();

        $notify[] = ['success', 'Status successfully updated.'];
        return redirect()->back()->withNotify($notify);
    }

    public function auctionWishlist()
    {
        $user = auth()->user();
        $pageTitle = 'Wishlist';
        $wishlists = Wishlist::with('getProduct')->where('user_id', $user->id)->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.wishlist', compact('pageTitle','wishlists'));
    }

    public function wishlist(Request $request)
    {
        $user = auth()->user();

        if($user)
        {
            $check = Wishlist::where('product_id', $request->product_id)->first();

            if($check)
            {
                $check->delete();
                $wishlistCount = Wishlist::where('user_id', $user->id)->count();
                return response()->json(['status' => trans('Successfully removed'), 'statusCode' => 1, 'wishlistCount' => $wishlistCount]);
            }else{
                $wishlist = new Wishlist();
                $wishlist->user_id = $user->id;
                $wishlist->product_id = $request->product_id;
                $wishlist->save();
                $wishlistCount = Wishlist::where('user_id', $user->id)->count();
                return response()->json(['status' => trans('Successfully added to wishlist'), 'statusCode' => 2, 'wishlistCount' => $wishlistCount]);
            }
        }else{
            return response()->json(['status' => 'Something wrong', 'statusCode' => 3]);
        }
    }

    public function deleteWishList($id)
    {
        $user = auth()->user();
        $wishList = Wishlist::where('user_id', $user->id)->where('id', $id)->first();
        $wishList->delete();
        $notify[] = ['success', 'Your wishlist successfully deleted.'];
        return redirect()->back()->withNotify($notify);
    }

    public function review(Request $request)
    {
        $request->validate([
            'rating'            => 'required|integer|min:1|max:5',
            'message'           => 'required'
        ]);

        $user = auth()->user();

        $product = Product::findOrFail($request->product_id);

        if($product->user_id != 0){
            if($user->id == $product->user_id){
                $notify[] = ['error','You can\'t review your own profile'];
                return redirect()->back()->withNotify($notify);
            }

            // $result = Winner::where('user_id', $user->id)
            //     ->where('product_owner_id', $product->user_id)
            //     ->get()->count();

            // if($result ==  0)
            // {
            //     $notify[] = ['error','You are not allow to review'];
            //     return redirect()->back()->withNotify($notify);
            // }

            $check = Review::where('user_id', $user->id)->where('merchant_id', $product->user_id)->count();
            if($check > 0)
            {
                $notify[] = ['error','You have already given a review'];
                return redirect()->back()->withNotify($notify);
            }

            $review = new Review();
            $review->user_id = $user->id;
            $review->product_id = $product->id;
            $review->merchant_id = $product->user_id;
            $review->rating = $request->rating;
            $review->message = $request->message;
            $review->status = '1';
            $review->save();

            $productOwner = User::find($product->user_id);

            if($productOwner->review_count == 0) {
                $productOwner->avg_review = $request->rating;
                $productOwner->review_count += 1;
                $productOwner->save();
            } else {
                $total_star = $productOwner->avg_review * $productOwner->review_count;
                $avg_star = ($total_star + $request->rating) / ($productOwner->review_count + 1);
                $productOwner->avg_review = $avg_star;
                $productOwner->review_count += 1;
                $productOwner->save();
            }

            $notify[] = ['success','Review posted!', '', '⭐️'];
            return redirect()->back()->withNotify($notify);

        } else {
            // $result = Winner::where('user_id', $user->id)
            //    ->where('product_owner_id', 0)
            //    ->get()->count();

            // if($result ==  0)
            // {
            //     $notify[] = ['error','You are not allow to review'];
            //     return redirect()->back()->withNotify($notify);
            // }

            $check = Review::where('user_id', $user->id)->where('merchant_id', 0)->count();

            if($check > 0)
            {
                $notify[] = ['error','You have already given a review'];
                return redirect()->back()->withNotify($notify);
            }

            $review = new Review();
            $review->user_id = $user->id;
            $review->merchant_id = $product->user_id;
            $review->rating = $request->rating;
            $review->message = $request->message;
            $review->save();

            $notify[] = ['success','Review posted!', '', '⭐️'];
            return redirect()->back()->withNotify($notify);
        }

    }

}
