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
            if (!preg_match('/^meta\//', $url->image) and $url->image) {
                $filePath = public_path('images/og/' . $url->image);
                if (file_exists($filePath)) {
                    $url->image = 'meta/' . $url->image;
                    $url->save();
                    rename(public_path($filePath), storage_path('app/public/' . $url->image));
                }
            } else if (preg_match('/^meta\//', $url->image)) {
                $filePath = storage_path('app/' . $url->image);
                if (file_exists($filePath)) {
                    rename($filePath, storage_path('app/public/' . $url->image));
                }

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
