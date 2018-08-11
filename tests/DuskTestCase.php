<?php

namespace Tests;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */

    public function setUp()
    {
        parent::setUp();
        // User::create([
        //     'name'     => 'admin',
        //     'email'    => 'admin@gmail.com',
        //     'password' => '$2y$10$b0qUap.WKTe0yJWaakRMSOwvsMhCfDkOMv61iNfpHljOe/CWEo/s.',
        // ]);
    }

    public static function prepare()
    {
        static::startChromeDriver();

    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()
        );
    }

}
