<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->longText('about_us')->nullable();
            $table->longText('returns_exchange')->nullable();
            $table->longText('contact_us')->nullable();
            $table->longText('terms_conditions')->nullable();
            $table->longText('delivery_returns')->nullable();
            $table->longText('privacy_policy')->nullable();
            $table->longText('disclaimer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
