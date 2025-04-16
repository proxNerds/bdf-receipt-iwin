<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participations', function (Blueprint $table) {
            $table->id();
            $table->string('crm_id');
            $table->integer('status')->default(0)->comment(
                '0  - not yet managed
            |    1  - awaiting confirmation
            |    2  - confirmed
            |   -1  - rejected'
            );
            $table->string('receipt_number');
            $table->string('receipt_total');
            $table->string('receipt_hour');
            $table->string('receipt_minute');
            $table->string('receipt_date');
            $table->string('receipt_img1_url')->nullable();
            $table->string('receipt_img2_url')->nullable();
            $table->string('region')->nullable();
            $table->string('shop')->nullable();
            $table->text('products')->nullable();
            $table->string('products_total')->nullable();
            $table->integer('sweepstake_id');
            $table->tinyInteger('won')->default(0);
            $table->string('win_code')->nullable();
            $table->boolean('privacy_tc');
            $table->boolean('privacy_age')->nullable();
            $table->boolean('privacy_nl')->default(0);
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
        Schema::dropIfExists('participations');
    }
};
