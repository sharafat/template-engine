<?php

namespace App\Models\Template\Variables;

use App\Models\Fees\FeeCollectionRecord;
use App\Models\Template\Variable;
use Illuminate\Support\Collection;

class FeesReceiptVariables extends VariableOperations
{
    public function __construct(
        private readonly ?FeeCollectionRecord $instance = null,
        private readonly ?string $feesEntriesTable = null,
    ) {
    }

    public function variables(): Collection
    {
        $amountInWords = numberToWords($this->instance?->entries?->sum('paid_amount') ?? 12345);

        return collect(
            [
                new Variable('Fees Entries', 'fees_entries', $this->feesEntriesTable, $this->feesEntriesTable),
                new Variable('Amount in Words', 'amount_in_words', $amountInWords, $amountInWords),
            ]
        );
    }
}
