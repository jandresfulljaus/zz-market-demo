<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            \Main\Geo\Database\Seeders\CountrySeeder::class,
            \Main\Geo\Database\Seeders\RegionSeeder::class,
            \Main\Geo\Database\Seeders\CitySeeder::class,
            \Main\People\Database\Seeders\PersonSeeder::class,

            \Main\Auth\Database\Seeders\OrganizationSeeder::class,
            \Main\Auth\Database\Seeders\UserSeeder::class,
            \Main\Auth\Database\Seeders\RoleSeeder::class,
            \Main\Auth\Database\Seeders\PermSeeder::class,
            \Main\Auth\Database\Seeders\BranchesSeeder::class,
            \Modules\Products\Database\Seeders\SbusSeeder::class,
            \Modules\Products\Database\Seeders\SectorsSeeder::class,
            \Modules\Products\Database\Seeders\ProductsSeeder::class,
            \Modules\Products\Database\Seeders\ImagesSeeder::class,
            \Modules\Products\Database\Seeders\CurrenciesSeeder::class,
            \Modules\Products\Database\Seeders\LanguagesSeeder::class,
            \Modules\Products\Database\Seeders\PricesSeeder::class,
            \Modules\Orders\Database\Seeders\StatusesSeeder::class,
            \Modules\Orders\Database\Seeders\ChannelsSeeder::class,
            \Modules\Orders\Database\Seeders\ReasonsSeeder::class,
            \Modules\Orders\Database\Seeders\ShippingsSeeder::class,
            \Modules\Orders\Database\Seeders\SalesSeeder::class,
            \Modules\Orders\Database\Seeders\OrdersSeeder::class,
            \Modules\Orders\Database\Seeders\ItemsSeeder::class,
        ]);
    }
}
