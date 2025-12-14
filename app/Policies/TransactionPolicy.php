<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Transaction;

class TransactionPolicy
{
    public function view(User $user, Transaction $transaction)
    {
        return $user->isAdmin() || $user->id === $transaction->user_id;
    }

    public function update(User $user, Transaction $transaction)
    {
        return $user->isAdmin() || $user->id === $transaction->user_id;
    }
}