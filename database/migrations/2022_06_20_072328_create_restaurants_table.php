<?php

use App\Models\User;
use App\Models\FoodType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(FoodType::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('phone');
            $table->string('address');
            $table->string('latitude', 20)->nullable()->default(null);
            $table->string('longitude', 20)->nullable()->default(null);
            $table->string('bank_account');
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('restaurants');
    }
};
