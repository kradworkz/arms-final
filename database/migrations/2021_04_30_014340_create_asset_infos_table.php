<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_infos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('type',30)->nullable();
            $table->string('remarks',200)->nullable();
            $table->date('maintenance')->nullable();
            $table->date('expiry')->nullable();
            $table->bigInteger('asset_id')->unsigned()->index();
            $table->foreign('asset_id')->references('id')->on('asset_lists')->onDelete('cascade');
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
        Schema::dropIfExists('asset_infos');
    }
}
