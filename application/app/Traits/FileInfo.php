<?php

namespace App\Traits;

trait FileInfo
{

    /*
    |--------------------------------------------------------------------------
    | File Information
    |--------------------------------------------------------------------------
    |
    | This trait basically contain the path of files and size of images.
    | All information are stored as an array. Developer will be able to access
    | this info as method and property using FileManager class.
    |
    */

    public function fileInfo(){
        $data['withdrawVerify'] = [
            'path'=>'assets/images/verify/withdraw'
        ];
        $data['depositVerify'] = [
            'path'      =>'assets/images/verify/deposit'
        ];
        $data['verify'] = [
            'path'      =>'assets/verify'
        ];
        $data['default'] = [
            'path'      => 'assets/images/general/default.png',
        ];
        $data['withdrawMethod'] = [
            'path'      => 'assets/images/withdraw/method',
            'size'      => '800x800',
        ];
        $data['ticket'] = [
            'path'      => 'assets/support',
        ];
        $data['logoIcon'] = [
            'path'      => 'assets/images/general',
        ];
        $data['favicon'] = [
            'size'      => '128x128',
        ];
        $data['extensions'] = [
            'path'      => 'assets/images/plugins',
            'size'      => '36x36',
        ];
        $data['seo'] = [
            'path'      => 'assets/images/seo',
            'size'      => '1180x600',
        ];
        $data['userProfile'] = [
            'path'      =>'assets/images/user/profile',
            'size'      =>'350x300',
        ];
        $data['adminProfile'] = [
            'path'      =>'assets/admin/images/profile',
            'size'      =>'400x400',
        ];
        $data['product'] = [
            'path'      => 'assets/images/product',
            'size'      => '760x484'
        ];
        $data['activity'] = [
            'path'      => 'assets/images/activity',
            'size'      => '760x484'
        ];
        $data['homeone'] = [
            'path'      =>'assets/images/frontend/homeone',
        ];
        $data['hometwo'] = [
            'path'      =>'assets/images/frontend/hometwo',
        ];
        $data['homethree'] = [
            'path'      =>'assets/images/frontend/homethree',
        ];
        $data['testimonial'] = [
            'path'      =>'assets/images/frontend/testimonial',
        ];
        $data['faq'] = [
            'path'      =>'assets/images/frontend/faq',
        ];
        $data['blog'] = [
            'path'      =>'assets/images/frontend/blog',
        ];
        $data['about'] = [
            'path'      =>'assets/images/frontend/about',
        ];
        $data['breadcumb'] = [
            'path'      =>'assets/images/frontend/breadcumb',
        ];
        $data['error_404'] = [
            'path'      =>'assets/images/frontend/error_404',
        ];
        $data['dashboard'] = [
            'path'      =>'assets/images/dashboard',
        ];
        return $data;
	}

}
