<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('assignments', 'classroom_id')) {
            return;
        }

        Schema::table('assignments', function (Blueprint $table) {
            $table->foreignId('classroom_id')
                ->nullable()
                ->after('teacher_id')
                ->constrained()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('assignments', 'classroom_id')) {
            return;
        }

        Schema::table('assignments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('classroom_id');
        });
    }
};
