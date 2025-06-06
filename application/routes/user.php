<?php

use Illuminate\Support\Facades\Route;

Route::namespace('User\Auth')->name('user.')->group(function () {

    Route::controller('LoginController')->group(function(){
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->name('logout');
        Route::post('/modal/login', 'modalLogin')->name('modal.login');
    });

    Route::controller('RegisterController')->group(function(){
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register')->middleware('registration.status');
        Route::post('check-mail', 'checkUser')->name('checkUser');
    });

    Route::controller('ForgotPasswordController')->group(function(){
        Route::get('password/reset', 'showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'sendResetCodeEmail')->name('password.email');
        Route::get('password/code-verify', 'codeVerify')->name('password.code.verify');
        Route::post('password/verify-code', 'verifyCode')->name('password.verify.code');
    });
    Route::controller('ResetPasswordController')->group(function(){
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });

    Route::controller('SocialiteController')->prefix('social')->group(function () {
        Route::get('login/{provider}', 'socialLogin')->name('social.login');
        Route::get('login/callback/{provider}', 'callback')->name('social.login.callback');
    });
});

Route::middleware('auth')->name('user.')->group(function () {
    //authorization
    Route::namespace('User')->controller('AuthorizationController')->group(function(){
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend/verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify/email', 'emailVerification')->name('verify.email');
        Route::post('verify/mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify/g2fa', 'g2faVerification')->name('go2fa.verify');
    });

    Route::middleware(['check.status'])->group(function () {

        Route::post('user/delete', 'User\UserController@deleteUserData')->name('delete');
        Route::get('user/data', 'User\UserController@userData')->name('data');
        Route::post('user/data/submit', 'User\UserController@userDataSubmit')->name('data.submit');

        Route::middleware('registration.complete')->namespace('User')->group(function () {

            Route::controller('UserController')->group(function(){
                Route::get('dashboard', 'home')->name('home');

                Route::get('fetch-visits', 'fetchVisits')->name('fetch.visits');

                Route::middleware('gm')->group(function () {
                    // Fetch Statistics
                    Route::get('fetch-stats', 'fetchStats')->name('fetch.stats');
                    Route::get('fetch-gym-stats', 'fetchGymVisits')->name('fetch.gym.visits');
                    Route::get('fetch-trends', 'fetchTrends')->name('fetch.trends');

                    // Request History
                    Route::get('request/history', 'requestHistory')->name('request.history');
                    Route::post('request/history-store', 'requestHistoryStore')->name('request.history.store');

                    // Reviews History
                    Route::get('reviews/history', 'reviewsHistory')->name('reviews.history');
                    Route::post('reviews/history-store', 'reviewsHistoryStore')->name('reviews.history.store');
                });

                //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                // Review
                Route::post('review', 'review')->name('review');

                // Request
                Route::post('bid', 'bid')->name('bid');

                // wishlist
                Route::post('wishlist', 'wishlist')->name('wishlist');
                Route::get('wishlist', 'auctionWishlist')->name('auctionWishlist');
                Route::get('withlist/{id}', 'deleteWishList')->name('wishlist.delete');

                //KYC
                Route::get('kyc/form','kycForm')->name('kyc.form');
                Route::get('kyc/data','kycData')->name('kyc.data');
                Route::post('kyc/submit','kycSubmit')->name('kyc.submit');

                //Report
                Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions','transactions')->name('transactions');

                Route::get('attachment-download/{fil_hash}','attachmentDownload')->name('attachment.download');
            });

            // Gym
            Route::middleware('kyc')->controller('ProductController')->name('product.')->prefix('gyms')->group(function(){
                Route::get('all', 'all')->name('index');
                Route::get('pending', 'pending')->name('pending');
                Route::get('live', 'live')->name('live');
                Route::get('upcoming', 'upcomming')->name('upcoming');
                Route::get('expired', 'expired')->name('expired');
                Route::get('cancel', 'cancel')->name('cancel');
                Route::get('create', 'create')->name('create');
                Route::post('store-product', 'store')->name('store');
                Route::get('{id}/edit', 'edit')->name('edit');
                Route::post('update-product/{id}', 'update')->name('update');
                Route::get('{id}/bids', 'productUsers')->name('users.list');
                Route::get('winners', 'winners')->name('winners');
                Route::post('delete', 'delete')->name('delete');
            });

            //Profile setting
            Route::controller('ProfileController')->group(function(){
                Route::get('profile/account', 'account')->name('profile.account');
                Route::post('profile/account', 'submitAccount');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
                Route::post('profile', 'profileUpdate')->name('profile.update');
            });

            //Profile setting
            Route::middleware('gm')->controller('ProfileController')->group(function(){
                Route::get('profile/setting', 'setting')->name('profile.setting');
                Route::post('profile/setting', 'submitProfile');
                Route::get('profile/rates', 'rates')->name('profile.rates');
                Route::post('profile/rates', 'submitRates');
            });

            // Withdraw
            Route::controller('WithdrawController')->prefix('withdraw')->name('withdraw')->group(function(){
                Route::get('/', 'withdrawMoney');
                Route::post('/', 'withdrawStore')->name('.money');
                Route::get('preview', 'withdrawPreview')->name('.preview');
                Route::post('preview', 'withdrawSubmit')->name('.submit');
                Route::get('history', 'withdrawLog')->name('.history');
            });
        });

        // Payment
        Route::middleware('registration.complete')->controller('Gateway\PaymentController')->group(function(){
            Route::any('/deposit', 'deposit')->name('deposit');
            Route::post('deposit/insert', 'depositInsert')->name('deposit.insert');
            Route::get('deposit/confirm', 'depositConfirm')->name('deposit.confirm');
            Route::get('deposit/manual', 'manualDepositConfirm')->name('deposit.manual.confirm');
            Route::post('deposit/manual', 'manualDepositUpdate')->name('deposit.manual.update');
        });
    });
});
