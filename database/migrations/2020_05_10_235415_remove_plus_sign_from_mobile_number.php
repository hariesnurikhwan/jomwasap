<?php

use App\ShortenedUrl;
use Illuminate\Database\Migrations\Migration;

class RemovePlusSignFromMobileNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
            ShortenedUrl::query()
                ->with('group')
                ->withTrashed()
                ->chunk(1000, function ($urls) {
                    $urls->each(function ($url) {

                        if ($url->type === 'single') {
                            $url->timestamps = false;

                            $url->update([
                                'mobile_number' => $url->mobile_number,
                            ]);

                        } else {
                            $url->group->each(function ($item) {
                                $item->timestamps = false;

                                $item->update([
                                    'mobile_number' => $item->mobile_number,
                                ]);
                            });
                        }

                    });
                });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
