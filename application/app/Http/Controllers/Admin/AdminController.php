<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Lib\CurlRequest;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\SearchHistory;
// use App\Models\Transaction;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Withdrawal;
use App\Models\SupportTicket;
use App\Models\Product;
use App\Models\Category;
use App\Models\Services;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

    public function dashboard()
    {
        Log::debug('DASHBOARD-IN');
        $pageTitle = 'Dashboard';

        // User Info
        $widget['total_users']             = User::count();
        $widget['verified_users']          = User::where('status', 1)->where('ev',1)->where('sv',1)->count();
        $widget['email_unverified_users']  = User::emailUnverified()->count();
        $widget['mobile_unverified_users'] = User::mobileUnverified()->count();

        // Gym Info
        $widget['total_gyms']             = Product::count();

        // UserLogin Report Graph
        $userLoginsReport = UserLogin::selectRaw("COUNT(*) as login_count, DATE_FORMAT(created_at, '%Y-%m-%d') as login_date")
            ->orderBy('login_date', 'desc')
            ->groupByRaw("DATE_FORMAT(created_at, '%Y-%m-%d')")
            ->limit(10)
            ->pluck('login_count', 'login_date');

        $userLogins['labels'] = $this->fetchWeekLogins()['labels'];
        $userLogins['values'] = $this->fetchWeekLogins()['series']['logins'];

        // UserLogin Report Graph
        $mostSearchedActivities = $this->getActivitiesByDateRange(6);

        $mostSearchedActivity = '--/--';
        if (count($mostSearchedActivities) > 0) {
            $mostSearchedActivity = $mostSearchedActivities[0]['title'];
        }

        $widget['top_activity'] = $mostSearchedActivity;

        // Get price range distribution
        $mostSearchedPrices = $this->getPricesByDateRange(6);

        $mostSearchedPrice = '--/--';
        if (count($mostSearchedPrices) > 0) {
            $mostSearchedPrice = $mostSearchedPrices[0]['title'];
        }

        $mostSearchedServices = $this->getServicesByDateRange(6);

        $widget['top_prices'] = $mostSearchedPrice;
        Log::debug('DASHBOARD-OUT');
        return view('admin.dashboard', compact('pageTitle', 'widget', 'userLogins', 'mostSearchedActivities', 'mostSearchedServices', 'mostSearchedPrices'));
    }

    // Logins Data
    public function processLoginsData($dateRange, $loginsData) {
        $logins = [];
        $totalLogins = 0;

        foreach ($dateRange as $date) {
            if (isset($loginsData[$date])) {
                $logins[] = $loginsData[$date]->count;
            } else {
                $logins[] = 0;
            }
        }

        return [
            'labels' => $dateRange,
            'series' => [
                'logins' => $logins,
            ],
        ];
    }

    public function fetchAllLogins() {
        $startYear = Carbon::now()->subYears(4)->startOfYear();
        $endYear = Carbon::now()->endOfYear();
        $dateRange = [];

        $currentYear = $startYear->copy();
        while ($currentYear->lte($endYear)) {
            $year = $currentYear->year;
            $dateRange[] = $year;
            $currentYear->addYear();
        }

        $visits = DB::table('user_logins')
            ->where('created_at', '>=', $startYear)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as count')
            )
            ->groupBy('year')
            ->orderBy('year')
            ->get()
            ->keyBy('year')
            ->toArray();

        return $this->processLoginsData($dateRange, $visits);
    }

    public function fetchYearLogins() {
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

        $visits = DB::table('user_logins')
            ->where('created_at', '>=', $startMonth)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
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

        return $this->processLoginsData($dateRange, $visits);
    }

    public function fetchMonthLogins() {
        $startDate = Carbon::now()->subDays(29)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $dateRange = [];

        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $dateRange[] = $currentDate->toDateString();
            $currentDate->addDay();
        }

        $visits = DB::table('user_logins')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();

        return $this->processLoginsData($dateRange, $visits);
    }

    public function fetchWeekLogins() {
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $dateRange = [];

        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $dateRange[] = $currentDate->toDateString();
            $currentDate->addDay();
        }

        $visits = DB::table('user_logins')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString())
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();

        return $this->processLoginsData($dateRange, $visits);
    }

    public function fetchLoginsData(Request $request) {
        $type = $request->type;

        $result = [];

        switch ($type) {
            case 'week':
                $result = $this->fetchWeekLogins();
                break;
            case 'month':
                $result = $this->fetchMonthLogins();
                break;
            case 'year':
                $result = $this->fetchYearLogins();
                break;
            case 'all':
                $result = $this->fetchAllLogins();
                break;
            default:
                $result = ['error' => 'Invalid type'];
            break;
        }

        return response()->json($result);
    }

    // Activities
    public function getActivitiesByDateRange($dateRange, $location = null) {
        $startDate = Carbon::now()->subDays($dateRange)->startOfDay();

        $trendsResult = SearchHistory::selectRaw("
                JSON_UNQUOTE(json_extract(activity_data.activity, '$')) AS activity,
                SUM(sh.search_count) AS count,
                city
            ")
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString());

        if ($location) {
            $trendsResult = $trendsResult->whereRaw('LOWER(city) LIKE ?', ['%' . strtolower($location) . '%']);
        }

        $trendsResult = $trendsResult->whereNotNull('sh.user_id')
            ->from('search_histories as sh')
            ->join(DB::raw("JSON_TABLE(sh.activities, '$[*]' COLUMNS (activity VARCHAR(255) PATH '$')) AS activity_data"), function($join) {
                $join->whereNotNull('sh.user_id');
            })
            ->groupBy('activity', 'city')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        $trends = [];
        foreach ($trendsResult as $trend) {
            $category = Category::findOrFail($trend->activity);
            if (!$category) {              // si no existe, lo ignoramos
                continue;
            }

            $trends[] = [
                'title' => $category->name,
                'count' => $trend->count,
                'location' => $trend->city
            ];
        }

        return $trends;
    }

    public function fetchActivities(Request $request) {
        $type = $request->type;
        $location = $request->location;

        $result = [];

        switch ($type) {
            case 'week':
                $result = $this->getActivitiesByDateRange(6, $location);
                break;
            case 'month':
                $result = $this->getActivitiesByDateRange(29, $location);
                break;
            case 'year':
                $result = $this->getActivitiesByDateRange(365, $location);
                break;
            case 'all':
                $result = $this->getActivitiesByDateRange(36500, $location);
                break;
            default:
                $result = ['error' => 'Invalid type'];
            break;
        }

        return response()->json($result);
    }

    // Services
    public function getServicesByDateRange($dateRange, $location = null) {
        $startDate = Carbon::now()->subDays($dateRange)->startOfDay();

        $trendsResult = SearchHistory::selectRaw("
                JSON_UNQUOTE(json_extract(service_data.service, '$')) AS service,
                SUM(sh.search_count) AS count,
                city
            ")
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', Carbon::now()->toDateTimeString());

        if ($location) {
            $trendsResult = $trendsResult->whereRaw('LOWER(city) LIKE ?', ['%' . strtolower($location) . '%']);
        }

        $trendsResult = $trendsResult->whereNotNull('sh.user_id')
            ->from('search_histories as sh')
            ->join(DB::raw("JSON_TABLE(sh.services, '$[*]' COLUMNS (service VARCHAR(255) PATH '$')) AS service_data"), function($join) {
                $join->whereNotNull('sh.user_id');
            })
            ->groupBy('service', 'city')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        $trends = [];
        foreach ($trendsResult as $trend) {
            $service = Services::find($trend->service);
            if (!$service) {
                continue;
            }
            $trends[] = [
                'title' => $service->name,
                'count' => $trend->count,
                'location' => $trend->city
            ];
        }

        return $trends;
    }

    public function fetchServices(Request $request) {
        $type = $request->type;
        $location = $request->location;

        $result = [];

        switch ($type) {
            case 'week':
                $result = $this->getServicesByDateRange(6, $location);
                break;
            case 'month':
                $result = $this->getServicesByDateRange(29, $location);
                break;
            case 'year':
                $result = $this->getServicesByDateRange(365, $location);
                break;
            case 'all':
                $result = $this->getServicesByDateRange(36500, $location);
                break;
            default:
                $result = ['error' => 'Invalid type'];
            break;
        }

        return response()->json($result);
    }

    // Prices
    public function getPricesByDateRange($dateRange, $location = null) {
        $startDate = Carbon::now()->subDays($dateRange)->startOfDay();

        $priceRanges = SearchHistory::select(
            DB::raw('city'),
            DB::raw('SUM(search_count) as total_searches'),
            DB::raw('CASE
                WHEN (min_price + max_price) / 2 BETWEEN 0 AND 30 THEN "0-30"
                WHEN (min_price + max_price) / 2 BETWEEN 30 AND 60 THEN "30-60"
                WHEN (min_price + max_price) / 2 BETWEEN 60 AND 90 THEN "60-90"
                WHEN (min_price + max_price) / 2 BETWEEN 90 AND 120 THEN "90-120"
                WHEN (min_price + max_price) / 2 BETWEEN 120 AND 150 THEN "120-150"
                ELSE "150+"
            END AS price_range')
        )
        ->where('created_at', '>=', $startDate)
        ->where('created_at', '<=', Carbon::now()->toDateTimeString());

        if ($location) {
            $priceRanges = $priceRanges->whereRaw('LOWER(city) LIKE ?', ['%' . strtolower($location) . '%']);
        }

        $priceRanges = $priceRanges->whereNotNull('user_id')
        ->groupBy('price_range', 'city')
        ->orderByDesc('total_searches')
        ->limit(5)
        ->get();

        $prices = [];
        foreach ($priceRanges as $price) {
            $prices[] = [
                'title' => $price->price_range,
                'count' => $price->total_searches,
                'location' => $price->city
            ];
        }

        return $prices;
    }

    public function fetchPrices(Request $request) {
        $type = $request->type;
        $location = $request->location;

        $result = [];

        switch ($type) {
            case 'week':
                $result = $this->getPricesByDateRange(6, $location);
                break;
            case 'month':
                $result = $this->getPricesByDateRange(29, $location);
                break;
            case 'year':
                $result = $this->getPricesByDateRange(365, $location);
                break;
            case 'all':
                $result = $this->getPricesByDateRange(36500, $location);
                break;
            default:
                $result = ['error' => 'Invalid type'];
            break;
        }

        return response()->json($result);
    }



    // Profile
    public function profile()
    {
        $pageTitle = 'Profile';
        $admin = auth('admin')->user();
        return view('admin.profile', compact('pageTitle', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => ['nullable','image',new FileTypeValidate(['jpg','jpeg','png'])]
        ]);
        $user = auth('admin')->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image;
                $user->image = fileUploader($request->image, getFilePath('adminProfile'), getFileSize('adminProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'Profile has been updated successfully'];
        return to_route('admin.profile')->withNotify($notify);
    }


    public function password()
    {
        $pageTitle = 'Password Setting';
        $admin = auth('admin')->user();
        return view('admin.profile', compact('pageTitle', 'admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = auth('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password doesn\'t match!!'];
            return back()->withNotify($notify);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        $notify[] = ['success', 'Password changed successfully.'];
        return to_route('admin.profile')->withNotify($notify);
    }

    public function notifications(){
        $notifications = AdminNotification::orderBy('id','desc')->with('user')->paginate(getPaginate());
        $pageTitle = 'Notifications';
        return view('admin.notifications',compact('pageTitle','notifications'));
    }


    public function notificationRead($id){
        $notification = AdminNotification::findOrFail($id);
        $notification->read_status = 1;
        $notification->save();
        $url = $notification->click_url;
        if ($url == '#') {
            $url = url()->previous();
        }
        return redirect($url);
    }

    public function readAll(){
        AdminNotification::where('read_status',0)->update([
            'read_status'=>1
        ]);
        $notify[] = ['success','Notifications read successfully'];
        return back()->withNotify($notify);
    }

    public function downloadAttachment($fileHash)
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


}
