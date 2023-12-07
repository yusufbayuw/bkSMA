<?php

namespace App\Observers;

use App\Models\Pilihan;
use App\Models\User;

class PilihanObserver
{
    /**
     * Handle the Pilihan "created" event.
     */
    public function created(Pilihan $pilihan): void
    {
        $userPilih = User::find($pilihan->user_id);
        $userPilih->is_can_choose = false;
        $userPilih->save();
    }

    /**
     * Handle the Pilihan "updated" event.
     */
    public function updated(Pilihan $pilihan): void
    {
        $userPilih = User::find($pilihan->user_id);
        $userPilih->is_can_choose = false;
        $userPilih->save();
    }

    /**
     * Handle the Pilihan "deleted" event.
     */
    public function deleted(Pilihan $pilihan): void
    {
        //
    }

    /**
     * Handle the Pilihan "restored" event.
     */
    public function restored(Pilihan $pilihan): void
    {
        //
    }

    /**
     * Handle the Pilihan "force deleted" event.
     */
    public function forceDeleted(Pilihan $pilihan): void
    {
        //
    }
}
