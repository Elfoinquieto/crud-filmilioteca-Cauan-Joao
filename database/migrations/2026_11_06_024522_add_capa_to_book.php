<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('capa')->nullable()->after('description');
            $table->string('capa_thumbnail')->nullable()->after('capa');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['capa', 'capa_thumbnail']);
        });
    }
};
