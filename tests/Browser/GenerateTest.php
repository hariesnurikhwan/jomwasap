<?php

namespace Tests\Browser;

use App\ShortenedUrl;
use App\User;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Tests\DuskTestCase;

class GenerateTest extends DuskTestCase
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
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testShowGeneratedLinks()
    {
        $user = factory(User::class)->create();

        $this->browse(function ($browser) {

            $url = ShortenedUrl::where('user_id', $user->id)->first();

            $browser->loginAs($user)
                ->visit('/generate')
                ->assertSee($url->alias);
        });
    }

    public function testCreateSingleLink()
    {

        $this->browse(function ($browser) {

            $user = factory(User::class)->create();

            $url = ShortenedUrl::make([
                'type'                => 'single',
                'mobile_number'       => '0189047264',
                'enable_lead_capture' => '0',
                'text'                => 'testpretext',
            ]);

            $browser->loginAs($user)
                ->visit('/generate/create')
                ->type('alias', $url->alias)
                ->select('type', $url->type)
                ->type('mobile_number', $url->mobile_number)
                ->select('enable_lead_capture', $url->enable_lead_capture)
                ->type('text', $url->text)
                ->click('.btn-success')
                ->assertPathIs('/generate/' . ShortenedUrl::latest()->first()->hashid);
        });
    }

    public function testCreateGroupLink()
    {
        $this->browse(function ($browser) {

            $user = User::find(1);

            $url = ShortenedUrl::make([
                'type'                => 'group',
                'enable_lead_capture' => '0',
                'text'                => 'testpretext',
            ]);

            $browser->loginAs($user)
                ->visit('/generate/create')
                ->resize(1200, 5000)
                ->type('alias', $url->alias)
                ->select('type', $url->type)
                ->value('[data-index="0"]', '0189047264')
                ->value('[data-index="1"]', '0189047288')
                ->select('enable_lead_capture', $url->enable_lead_capture)
                ->type('text', $url->text)
                ->click('.btn-success')
                ->assertPathIs('/generate/' . ShortenedUrl::latest()->first()->hashid);
        });
    }

    public function testShowLinkDetails()
    {
        $this->browse(function ($browser) {
            $user = User::find(1);
            $url  = ShortenedUrl::where('user_id', $user->id)->first();

            $browser->loginAs($user)
                ->visit(route('generate.show', $url->hashid))
                ->assertSee($url->alias)
                ->assertSee($url->enable_lead_capture ? 'Enabled' : 'Disabled')
                ->assertSee($url->text);
        });
    }

    public function testEditPageShowOldValues()
    {
        $this->browse(function ($browser) {
            $user = User::find(1);
            $url  = ShortenedUrl::where('user_id', $user->id)->first();

            $browser->loginAs($user)
                ->visit(route('generate.show', $url->hashid))
                ->click('.btn-success')
                ->assertSee($url->alias)
                ->assertInputValue('type', $url->type)
                ->assertInputValue('mobile_number', $url->mobile_number)
                ->assertValue('[name="enable_lead_capture"]', $url->enable_lead_capture)
                ->assertInputValue('text', $url->text ? $url->text : '')
                ->type('mobile_number', '018900')
                ->type('text', 'testoldvalue')
                ->click('#fbmetaNav')
                ->waitFor('[name="title"]')
                ->value('[name="title"]', 'metatagtitle')
                ->value('[name="description"]', 'metatagdesc')
                ->attach('[name="image"]', __DIR__ . '/images/jomwasap.png')
                ->click('#submit')
                ->assertSee($url->alias)
                ->assertInputValue('type', $url->type)
                ->assertInputValue('mobile_number', '018900')
                ->assertValue('[name="enable_lead_capture"]', $url->enable_lead_capture)
                ->assertInputValue('text', 'testoldvalue')
                ->click('#fbmetaNav')
                ->assertInputValue('[name="title"]', 'metatagtitle')
                ->assertInputValue('[name="description"]', 'metatagdesc');

        });
    }

    public function testCreatePageShowOldValues()
    {
        $this->browse(function ($browser) {
            $user = User::find(1);
            $url  = ShortenedUrl::where('user_id', $user->id)->first();

            $browser->loginAs($user)
                ->visit(route('generate.create'))
                ->select('type', 'single')
                ->type('mobile_number', '01800')
                ->select('enable_lead_capture', '0')
                ->type('text', 'testoldvalue')
                ->click('#fbmetaNav')
                ->waitFor('[name="title"]')
                ->value('[name="title"]', 'metatagtitle')
                ->value('[name="description"]', 'metatagdesc')
                ->attach('[name="image"]', __DIR__ . '/images/jomwasap.png')
                ->click('#submit')
                ->assertValue('[name="type"]', 'single')
                ->assertInputValue('mobile_number', '01800')
                ->assertValue('[name="enable_lead_capture"]', '0')
                ->assertInputValue('text', 'testoldvalue')
                ->click('#fbmetaNav')
                ->assertInputValue('[name="title"]', 'metatagtitle')
                ->assertInputValue('[name="description"]', 'metatagdesc');

        });
    }
}
