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
        $table->rememberToken(); // Ini akan membuat kolom string nullable bernama `remember_token`
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('remember_token');
    });
}

};
