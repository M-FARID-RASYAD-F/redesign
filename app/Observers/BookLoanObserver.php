<?php

namespace App\Observers;

use App\Models\BookLoan;

class BookLoanObserver
{
    /**
     * Handle the BookLoan "creating" event.
     */
    public function creating(BookLoan $loan): void
    {
        if (empty($loan->loan_code)) {
            $year = date('Y');
            do {
                $randomPart = str_pad((string) random_int(1000, 9999), 4, '0', STR_PAD_LEFT);
                $code = 'PINJAM-' . $year . '-' . $randomPart;
            } while (BookLoan::where('loan_code', $code)->exists());

            $loan->loan_code = $code;
        }
    }
}
