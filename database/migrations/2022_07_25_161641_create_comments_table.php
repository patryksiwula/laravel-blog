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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
			$table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->unsignedBigInteger('commentable_id');
			$table->string('commentable_type');
			$table->unsignedBigInteger('parent_id')->nullable();
			$table->text('content');
            $table->timestamps();
        });

		Schema::table('comments', function (Blueprint $table) {
			$table->foreign('parent_id')->references('id')->on('comments')->cascadeOnUpdate()->cascadeOnDelete();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
