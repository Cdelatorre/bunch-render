<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // core

            UsersSeeder::class,
            CategoriesSeeder::class,
            ServicesSeeder::class,
            ProductsSeeder::class,
            ProductImagesSeeder::class,
            ProductUsersSeeder::class,
            ReviewsSeeder::class,
            WishlistsSeeder::class,
            TransactionsSeeder::class,
            DepositsSeeder::class,
            UsersDemoSeeder::class,

            ViewedHistoriesSeeder::class,
            AdminNotificationsSeeder::class,
            FormsSeeder::class,
            // new
            LanguagesSeeder::class,
            PagesSeeder::class,
            SectionsSeeder::class,
            FrontendSectionsSeeder::class,
            GeneralSettingsSeeder::class,
            ExtensionsSeeder::class,
            GatewaysSeeder::class,
            CurrenciesSeeder::class,
            EmailTemplatesSeeder::class,
            SmsTemplatesSeeder::class,
            NotificationsSeeder::class,
            FrontendsSeeder::class,
            AdminSeeder::class,
            UserLoginsSeeder::class,
            SearchHistoriesSeeder::class,
            WithdrawalsSeeder::class,

            CategoryProductSeeder::class,
            ServiceProductSeeder::class,
            BidsSeeder::class,
            NotificationTemplatesSeeder::class,
            MissingProductImagesSeeder::class,
            BlogSeeder::class,
        ]);
    }
}
