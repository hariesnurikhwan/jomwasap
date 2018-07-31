<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddTitleDescriptionAndImageColumnInShortenedUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('shortened_urls', function ($table) {
            $table->string('title')->nullable()->after('text');
            $table->string('description')->nullable()->after('title');
            $table->string('image')->nullable()->after('description');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shortened_urls', function ($table) {
            $table->dropColumn('title');
            $table->dropColumn('description');
            $table->dropColumn('image');
        });
    }
}
