<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Add performance indexes for common queries
     */
    public function up(): void
    {
        // Articles table indexes - check columns exist first
        if (Schema::hasTable('articles')) {
            Schema::table('articles', function (Blueprint $table) {
                // Category + status for filtered lists
                if (Schema::hasColumn('articles', 'category') && Schema::hasColumn('articles', 'status')) {
                    if (!$this->indexExists('articles', 'articles_category_status_idx')) {
                        $table->index(['category', 'status'], 'articles_category_status_idx');
                    }
                }
                
                // Status + created_at for recent published articles
                if (Schema::hasColumn('articles', 'status')) {
                    if (!$this->indexExists('articles', 'articles_status_date_idx')) {
                        $table->index(['status', 'created_at'], 'articles_status_date_idx');
                    }
                }
                
                // User's articles
                if (Schema::hasColumn('articles', 'user_id') && Schema::hasColumn('articles', 'status')) {
                    if (!$this->indexExists('articles', 'articles_user_status_idx')) {
                        $table->index(['user_id', 'status'], 'articles_user_status_idx');
                    }
                }
            });
        }

        // Search logs for analytics
        if (Schema::hasTable('search_logs')) {
            Schema::table('search_logs', function (Blueprint $table) {
                if (!$this->indexExists('search_logs', 'search_logs_created_idx')) {
                    $table->index('created_at', 'search_logs_created_idx');
                }
            });
        }

        // AI generations for user history
        if (Schema::hasTable('ai_generations')) {
            Schema::table('ai_generations', function (Blueprint $table) {
                if (Schema::hasColumn('ai_generations', 'user_id') && Schema::hasColumn('ai_generations', 'type')) {
                    if (!$this->indexExists('ai_generations', 'ai_gen_user_type_idx')) {
                        $table->index(['user_id', 'type'], 'ai_gen_user_type_idx');
                    }
                }
            });
        }

        // User achievements
        if (Schema::hasTable('user_achievements')) {
            Schema::table('user_achievements', function (Blueprint $table) {
                if (Schema::hasColumn('user_achievements', 'user_id') && Schema::hasColumn('user_achievements', 'earned_at')) {
                    if (!$this->indexExists('user_achievements', 'user_ach_earned_idx')) {
                        $table->index(['user_id', 'earned_at'], 'user_ach_earned_idx');
                    }
                }
            });
        }
    }

    /**
     * Check if index exists
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
        return count($indexes) > 0;
    }

    public function down(): void
    {
        // Safe drop - only if exists
        $drops = [
            'articles' => ['articles_category_status_idx', 'articles_status_date_idx', 'articles_user_status_idx'],
            'search_logs' => ['search_logs_created_idx'],
            'ai_generations' => ['ai_gen_user_type_idx'],
            'user_achievements' => ['user_ach_earned_idx'],
        ];

        foreach ($drops as $table => $indexes) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) use ($indexes) {
                    foreach ($indexes as $index) {
                        try {
                            $table->dropIndex($index);
                        } catch (\Exception $e) {
                            // Index doesn't exist, ignore
                        }
                    }
                });
            }
        }
    }
};
