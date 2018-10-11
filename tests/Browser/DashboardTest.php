<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;

class DashboardTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testDashboard()
    {
        $this->browse(function ($browser) {
            $user = User::find(1);

            $urls              = $user->url()->with('hits')->withCount(['hits', 'lead'])->get();
            $total_hits_count  = 0;
            $total_leads_count = 0;

            foreach ($urls as $url) {
                $total_leads_count = $total_leads_count + $url->lead_count;
            }

            foreach ($urls as $url) {
                $total_hits_count = $total_hits_count + $url->hits_count;
            }

            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee($user->url()->count())
                ->assertSee($total_leads_count)
                ->assertSee($total_hits_count);
        });
    }
}
