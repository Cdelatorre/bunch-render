<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Image;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $pageTitle = 'Global Settings';
        $timezones = json_decode(file_get_contents(resource_path('views/admin/components/timezone.json')));
        return view('admin.setting.general', compact('pageTitle','timezones'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name'       => 'required|string|max:40',
            'cur_text'        => 'required|string|max:40',
            'cur_sym'         => 'required|string|max:40',
            'base_color'      => 'required|regex:/^[a-f0-9]{6}$/i',
            'secondary_color' => 'required|regex:/^[a-f0-9]{6}$/i',
            'timezone'        => 'required',
            'homesection'     => 'required|in:1,2,3'
        ]);


        $timezoneFile = config_path('timezone.php');

        $content = '<?php $timezone = '.$request->timezone.' ?>';
        file_put_contents($timezoneFile, $content);

        $general = GeneralSetting::first();
        $general->site_name = $request->site_name;
        $general->cur_text = $request->cur_text;
        $general->cur_sym = $request->cur_sym;
        $general->base_color = $request->base_color;
        $general->secondary_color = $request->secondary_color;
        $general->kv = $request->kv ? 1 : 0;
        $general->ev = $request->ev ? 1 : 0;
        $general->en = $request->en ? 1 : 0;
        $general->sv = $request->sv ? 1 : 0;
        $general->sn = $request->sn ? 1 : 0;
        $general->force_ssl = $request->force_ssl ? 1 : 0;
        $general->secure_password = $request->secure_password ? 1 : 0;
        $general->registration = $request->registration ? 1 : 0;
        $general->agree = $request->agree ? 1 : 0;
        $general->homesection = $request->homesection;
        $general->save();



        Cache::forget('GeneralSetting');
        Cache::put('GeneralSetting', $general);


        $notify[] = ['success', 'General Settings has been updated successfully'];
        return back()->withNotify($notify);
    }

    public function logoIcon()
    {
        $pageTitle = 'Logo & Favicon';
        return view('admin.setting.logo_icon', compact('pageTitle'));
    }

    public function logoIconUpdate(Request $request)
    {
        $request->validate([
            'logo' => ['image',new FileTypeValidate(['jpg','jpeg','png'])],
            'favicon' => ['image',new FileTypeValidate(['png'])],
        ]);
        if ($request->hasFile('logo')) {
            try {
                $path = getFilePath('logoIcon');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                Image::make($request->logo)->save($path . '/logo.png');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the logo'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('favicon')) {
            try {
                $path = getFilePath('logoIcon');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $size = explode('x', getFileSize('favicon'));
                Image::make($request->favicon)->resize($size[0], $size[1])->save($path . '/favicon.png');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the favicon'];
                return back()->withNotify($notify);
            }
        }
        if ($request->hasFile('logo_white')) {
            try {
                $path = getFilePath('logoIcon');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                Image::make($request->logo_white)->save($path . '/logo_white.png');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the logo'];
                return back()->withNotify($notify);
            }
        }
        $notify[] = ['success', 'Logo & favicon has been updated successfully'];
        return redirect()->to(url()->previous() . '#refresh')->withNotify($notify);
    }

    public function cookie(){
        $pageTitle = 'GDPR Cookie';
        $cookie = Frontend::where('data_keys','cookie.data')->firstOrFail();
        return view('admin.setting.cookie',compact('pageTitle','cookie'));
    }

    public function cookieSubmit(Request $request){
        $request->validate([
            'short_desc'=>'required|string|max:255',
            'description'=>'required',
        ]);
        $cookie = Frontend::where('data_keys','cookie.data')->firstOrFail();
        $cookie->data_values = [
            'short_desc' => $request->short_desc,
            'description' => $request->description,
            'status' => $request->status ? 1 : 0,
        ];
        $cookie->save();
        $notify[] = ['success','Cookie policy has been updated successfully'];
        return back()->withNotify($notify);
    }

    public function customCss()
    {
        $pageTitle = 'Custom CSS';
        $file = activeTemplate(true) . 'css/custom.css';
        $file_content = @file_get_contents($file);
        return view('admin.setting.custom_css', compact('pageTitle', 'file_content'));
    }


    public function customCssSubmit(Request $request)
    {
        $file = activeTemplate(true) . 'css/custom.css';
        if (!file_exists($file)) {
            fopen($file, "w");
        }
        file_put_contents($file, $request->css);
        $notify[] = ['success', 'CSS updated successfully'];
        return back()->withNotify($notify);
    }

    public function socialiteCredentials()
    {
        $pageTitle = 'Social Login Credentials';
        return view('admin.setting.social_credential', compact('pageTitle'));
    }
    public function updateSocialiteCredentialStatus($key)
    {
        $general = gs();
        $credentials = $general->socialite_credentials;
        try {
            $credentials->$key->status = $credentials->$key->status == 1 ? 0 : 1;
        } catch (\Throwable $th) {
            abort(404);
        }
        $general->socialite_credentials = $credentials;
        $general->save();
        $notify[] = ['success', 'Status changed successfully'];
        return back()->withNotify($notify);
    }
    public function updateSocialiteCredential(Request $request, $key)
    {
        $general = gs();
        $credentials = $general->socialite_credentials;
        try {
            @$credentials->$key->client_id = $request->client_id;
            @$credentials->$key->client_secret = $request->client_secret;
        } catch (\Throwable $th) {
            abort(404);
        }
        $general->socialite_credentials = $credentials;
        $general->save();
        $notify[] = ['success', 'Credential updated successfully'];
        return back()->withNotify($notify);
    }
}
