<?php

namespace App\Jobs;

use App\Models\SocialMediaAccount;
use App\Services\SocialMediaService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SyncSocialMediaPosts implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public ?int $accountId = null
    ) {
    }

    public function handle(
        SocialMediaService $service
    ): void {
        if ($this->accountId) {
            $account = SocialMediaAccount::find($this->accountId);

            if (!$account || !$account->status) {
                return;
            }

            try {
                $service->syncAccount($account);
            } catch (\Throwable $e) {
                Log::error(
                    'Social media sync failed.',
                    [
                        'account_id' => $account->id,
                        'platform' => $account->platform,
                        'error' => $e->getMessage(),
                    ]
                );
            }

            return;
        }

        $accounts = SocialMediaAccount::query()
            ->where('status', true)
            ->get();

        foreach ($accounts as $account) {
            try {
                $service->syncAccount($account);
            } catch (\Throwable $e) {
                Log::error(
                    'Social media sync failed.',
                    [
                        'account_id' => $account->id,
                        'platform' => $account->platform,
                        'error' => $e->getMessage(),
                    ]
                );
            }
        }
    }
}