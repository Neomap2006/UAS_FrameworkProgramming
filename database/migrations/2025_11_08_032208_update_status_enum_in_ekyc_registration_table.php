<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check database driver
        if (DB::getDriverName() === 'sqlite') {
            // SQLite doesn't support MODIFY COLUMN or ENUM
            // The column type is already TEXT in SQLite, so we just need to ensure the constraint
            // In SQLite, we can't modify the column type, but we can add a check constraint
            // For now, we'll skip this migration for SQLite as TEXT can store any string value
            return;
        }

        // For MySQL/MariaDB
        DB::statement("ALTER TABLE ekyc_registrations MODIFY COLUMN status ENUM('draft', 'submitted', 'accepted','rejected') DEFAULT 'draft'");
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        // Rollback ke enum semula
        DB::statement("ALTER TABLE ekyc_registrations MODIFY COLUMN status ENUM('draft', 'submitted') DEFAULT 'draft'");
    }
};
