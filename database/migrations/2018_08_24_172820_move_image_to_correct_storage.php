<?php

use App\ShortenedUrl;
use Illuminate\Database\Migrations\Migration;

class MoveImageToCorrectStorage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $urls = ShortenedUrl::withTrashed()->get();

        foreach ($urls as $url) {
            if (!preg_match('/^meta\//', $url->image) && $url->image === !null) {
                rename(public_path('images/og/' . $url->image), storage_path('app/public/meta/' . $url->image));
                $url->image = 'meta/' . $url->image;
                $url->save();

            } else if (preg_match('/^meta\//', $url->image)) {
                rename(storage_path('app/' . $url->image), storage_path('app/public/' . $url->image));

            }
        }
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
