<?php

use App\Models\FoodParty;
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
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('price');
            $table->foreignIdFor(FoodType::class)->nullable()->constrained()->nullOnDelete();
            $table->integer('discount')->nullable();
            $table->foreignIdFor(FoodParty::class)->nullable()->constrained()->nullOnDelete();
            $table->boolean('status')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('food');
    }
};
