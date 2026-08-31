<?php

namespace App\Console\Commands;

use App\Models\ArchivedLog;
use App\Models\ChildProfile;
use App\Models\CommunicationLog;
use App\Models\XpLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DataRetentionCleanup extends Command
{
    protected $signature = 'data:retention-cleanup {--days=365 : Age in days to archive/delete}';
    protected $description = 'Archive or delete data older than the retention period per COPPA/GDPR-K';

    public function handle()
    {
        $days = (int) $this->option('days');
        $cutoff = now()->subDays($days);

        $this->info("Processing data retention for records older than {$days} days...");

        // Archive old XP logs
        $oldXpLogs = XpLog::where('created_at', '<', $cutoff)->count();
        if ($oldXpLogs > 0) {
            ArchivedLog::insert(
                XpLog::where('created_at', '<', $cutoff)->get()->map(fn($log) => [
                    'original_type' => 'xp_log',
                    'original_id' => $log->id,
                    'data' => json_encode($log->toArray()),
                    'archived_at' => now(),
                ])->toArray()
            );
            XpLog::where('created_at', '<', $cutoff)->delete();
        }
        $this->info("Archived {$oldXpLogs} XP logs.");

        // Archive old communication logs
        $oldComms = CommunicationLog::where('created_at', '<', $cutoff)->count();
        if ($oldComms > 0) {
            ArchivedLog::insert(
                CommunicationLog::where('created_at', '<', $cutoff)->get()->map(fn($log) => [
                    'original_type' => 'communication_log',
                    'original_id' => $log->id,
                    'data' => json_encode($log->toArray()),
                    'archived_at' => now(),
                ])->toArray()
            );
            CommunicationLog::where('created_at', '<', $cutoff)->delete();
        }
        $this->info("Archived {$oldComms} communication logs.");

        // Mark inactive children for deletion notice (no activity in 2 years)
        $inactiveChildren = ChildProfile::whereDoesntHave('xpLogs', function ($q) {
            $q->where('created_at', '>=', now()->subYears(2));
        })->where('created_at', '<', now()->subYears(2))->count();

        if ($inactiveChildren > 0) {
            $this->warn("{$inactiveChildren} children inactive for 2+ years found. They will be flagged for deletion.");
            // Flag them - the GDPR deletion request endpoint will handle actual removal
            ChildProfile::whereDoesntHave('xpLogs', function ($q) {
                $q->where('created_at', '>=', now()->subYears(2));
            })->where('created_at', '<', now()->subYears(2))
                ->update(['metadata' => \DB::raw("JSON_SET(COALESCE(metadata, '{}'), '$.flagged_for_deletion', '1')")]);
        }

        $this->info('Data retention cleanup complete.');
        return Command::SUCCESS;
    }
}
