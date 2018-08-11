<?php

namespace Tests\Browser;

use App\ShortenedUrl;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Tests\DuskTestCase;

class VisitUrlTest extends DuskTestCase
{

    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
            '--window-size=1920,3000',
            'start-maximized',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    public function testRedirectedToLeadPageIfLeadEnabled()
    {
        $this->browse(function ($browser) {
            $url = ShortenedUrl::where('enable_lead_capture', 1)->first();

            $browser->visit('/go/' . $url->alias)
                ->assertSee('Lead Capture');
        });
    }

    public function testVisitUrl()
    {
        $this->browse(function ($browser) {
            $url = ShortenedUrl::where('enable_lead_capture', 0)->first();

            $browser->visit('/go/' . $url->alias)
                ->assertSee("* Click WhatsApp for Web if you don't have WhatsApp for OS X.")
                ->click('[platform="web"]')
                ->pause(2000)
                ->assertSee('WHATSAPP WEB');
        });
    }

}
