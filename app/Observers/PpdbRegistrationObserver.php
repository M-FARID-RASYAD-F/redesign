<?php

namespace App\Observers;

use App\Models\PpdbRegistration;

class PpdbRegistrationObserver
{
    /**
     * Handle the PpdbRegistration "creating" event.
     */
    public function creating(PpdbRegistration $registration): void
    {
        if (empty($registration->no_pendaftaran)) {
            $year = date('Y');
            $count = PpdbRegistration::whereYear('created_at', $year)->count() + 1;
            $noPendaftaran = 'PPDB-' . $year . '-'
                . str_pad((string) $count, 4, '0', STR_PAD_LEFT);

            while (PpdbRegistration::where('no_pendaftaran', $noPendaftaran)->exists()) {
                $count++;
                $noPendaftaran = 'PPDB-' . $year . '-'
                    . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
            }

            $registration->no_pendaftaran = $noPendaftaran;
        }
    }
}
