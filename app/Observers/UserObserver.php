<?php

namespace App\Observers;

use App\Models\Pilihan;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $nilaiOld = $user->getOriginal('nilai');
        $nilaiNew = $user->nilai;
        if ($nilaiOld != $nilaiNew) {
            $pilihan = Pilihan::where('user_id', $user->id)->first();
            if ($pilihan) {
                $pilihan->nilai = $nilaiNew;
                $pilihan->save();
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
