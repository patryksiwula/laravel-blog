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
        Schema::table('users', function (Blueprint $table) {
            $table->string('image_path')->default('https://via.placeholder.com/200x200.png/CCCCCC?text=User');
			$table->string('thumbnail_sm_path')->default('https://via.placeholder.com/80x80.png/CCCCCC?text=User');
			$table->string('thumbnail_xs_path')->default('https://via.placeholder.com/40x40.png/CCCCCC?text=User');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('image_path');
			$table->dropColumn('thumbnail_sm_path');
			$table->dropColumn('thumbnail_xs_path');
        });
    }
};
