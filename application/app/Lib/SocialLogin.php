<?php

namespace App\Lib;

use Exception;
use App\Models\User;
use App\Constants\Status;
use App\Models\UserLogin;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Facades\Socialite;

class SocialLogin
{
    private $provider;
    public function __construct($provider)
    {
        $this->provider = $provider;
        $this->configuration();
    }

    public function redirectDriver()
    {
        return Socialite::driver($this->provider)->redirect();
    }

    private function configuration()
    {
        $provider = $this->provider;
        $configuration = gs()->socialite_credentials->$provider;
        Config::set('services.' . $provider, [
            'client_id'     => $configuration->client_id,
            'client_secret' => $configuration->client_secret,
            'redirect'      => route('user.social.login.callback', $provider),
        ]);

    }

    public function login()
    {
        $user = Socialite::driver($this->provider)->stateless()->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))->user();

        $username = $this->generateUsername($user->email);
        $userData = User::where('email', @$user->email)->first();

        if (!$userData) {
            $emailExists = User::where('email', @$user->email)->exists();
            if ($emailExists) {
                throw new Exception('Email already exists');
            }

            $userData = $this->createUser($user, $this->provider);
        }


        auth()->login($userData);
        $this->loginLog($userData);
        $notify[] = ['success','You have successfully logged in.'];
        return to_route('user.home')->withNotify($notify);
    }

    private function createUser($user, $provider)
    {
        $general = gs();
        // $password = getTrx(8);
        $password = $user->email;
        $firstName = preg_replace('/\W\w+\s*(\W*)$/', '$1', $user->name);
        $pieces = explode(' ', $user->name);
        $lastName = array_pop($pieces);
        $username = $this->generateUsername($user->email);

        if (@$firstName) {
            $firstName = $firstName;
        }
        if (@$lastName) {
            $lastName = $lastName;
        }

        $newUser = new User();
        $newUser->username = $username;
        $newUser->email = $user->email;
        $newUser->password = Hash::make($password);
        $newUser->firstname = $firstName;
        $newUser->lastname = $lastName;
        $newUser->status = 1;
        $newUser->kv = 0;
        $newUser->ev = 1;
        $newUser->sv = 1;
        $newUser->ts = 0;
        $newUser->tv = 1;
        $newUser->gm = 0;
        $newUser->reg_step = 0;
        $newUser->login_by = $provider;

        if (@$user->avatar) {
            $fileName = uniqid() . time() . '.jpg';
            file_put_contents(getFilePath('userProfile') . '/' . $fileName, file_get_contents($this->provider != 'facebook' ? $user->avatar : $user->avatar . '&access_token=' . $user->token));
            $newUser->image = $fileName;
        }

        $newUser->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $newUser->id;
        $adminNotification->title = 'New member registered';
        $adminNotification->click_url = urlPath('admin.users.detail', $newUser->id);
        $adminNotification->save();

        return $newUser;
    }

    private function loginLog($user)
    {
        //Login Log Create
        $ip = getRealIP();
        $exist = UserLogin::where('user_ip', $ip)->first();
        $userLogin = new UserLogin();

        //Check exist or not
        if ($exist) {
            $userLogin->longitude =  $exist->longitude;
            $userLogin->latitude =  $exist->latitude;
            $userLogin->city =  $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country =  $exist->country;
        } else {
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude =  @implode(',', $info['long']);
            $userLogin->latitude =  @implode(',', $info['lat']);
            $userLogin->city =  @implode(',', $info['city']);
            $userLogin->country_code = @implode(',', $info['code']);
            $userLogin->country =  @implode(',', $info['country']);
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip =  $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();
    }


    protected function generateUsername($email)
    {
        $username = preg_replace('/[^a-zA-Z0-9]/', '', explode('@', $email)[0]);

        $originalUsername = $username;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
