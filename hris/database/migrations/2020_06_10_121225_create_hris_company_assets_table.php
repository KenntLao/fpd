<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisCompanyAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_company_assets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code');
            $table->bigInteger('asset_type_id');
            $table->bigInteger('employee_id')->nullable();
            $table->longText('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_company_assets');
    }
}
