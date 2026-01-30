<?php

namespace App\Services;

use App\Models\User;

class ReputationService
{
    public const POINTS_CREATE_ARTICLE = 10;
    public const POINTS_EDIT_ARTICLE = 5;
    public const POINTS_COMMENT = 2;
    public const POINTS_RECEIVE_UPVOTE = 1;
    public const POINTS_REVISION_APPROVED = 15;

    public function award(User $user, int $points, string $reason = null): void
    {
        $user->increment('reputation_score', $points);
        
        // TODO: Log this transaction in a reputation_log table if we want audit trails
    }

    public function deduct(User $user, int $points, string $reason = null): void
    {
        $user->decrement('reputation_score', $points);
    }
}
