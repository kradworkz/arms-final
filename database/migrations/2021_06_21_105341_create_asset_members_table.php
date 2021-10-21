<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_members', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallIncrements('id');
            $table->smallInteger('borrowed_to')->unsigned()->index();
            $table->foreign('borrowed_to')->references('id')->on('member_municipalities')->onDelete('cascade');  
            $table->smallInteger('borrowed_by')->unsigned()->index();
            $table->foreign('borrowed_by')->references('id')->on('member_municipalities')->onDelete('cascade');
            $table->smallInteger('log_id')->unsigned()->index();
            $table->foreign('log_id')->references('id')->on('asset_logs')->onDelete('cascade'); 
            $table->tinyInteger('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')->on('dropdowns')->onDelete('cascade'); 
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
        Schema::dropIfExists('asset_members');
    }
}
