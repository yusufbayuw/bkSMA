<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Pilihan;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class PilihanObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Pilihan "created" event.
     */
    public function created(Pilihan $pilihan): void
    {
        $this->updateUser($pilihan);
        $this->updateRanking();
    }

    /**
     * Handle the Pilihan "updated" event.
     */
    public function updated(Pilihan $pilihan): void
    {
        $this->updateUser($pilihan);
        $this->updateRanking();
    }

    /**
     * Handle the Pilihan "deleted" event.
     */
    public function deleted(Pilihan $pilihan): void
    {
        $this->updateRanking();
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

    /**
     * Update the user after Pilihan is created or updated.
     */
    private function updateUser(Pilihan $pilihan): void
    {
        $userPilih = User::find($pilihan->user_id);
        $userPilih->is_can_choose = false;
        $userPilih->is_choosed = true;
        $userPilih->save();
    }

    /**
     * Update the ranking after Pilihan is created, updated, deleted, restored, or force deleted.
     */
    private function updateRanking(): void
    {
        $rankedData = DB::table('pilihans')
            ->select('id', 'nilai', 'jurusan_id')
            ->selectRaw('ROW_NUMBER() OVER (PARTITION BY jurusan_id ORDER BY nilai DESC) as rank')
            ->get();

        foreach ($rankedData as $data) {
            // Update the Pilihan model with the calculated ranking
            Pilihan::where('id', $data->id)->update(['ranking' => $data->rank]);
        }
    }
}
