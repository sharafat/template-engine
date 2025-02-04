<?php

namespace App\Models\Template\Templates;

use App\Models\Fees\FeeCollectionRecord;
use App\Models\Fees\FeeCollectionRecordEntry;
use App\Models\School\School;
use App\Models\Template\Template;
use App\Models\Template\Variables\FeesReceiptVariables;
use App\Models\Template\Variables\InstituteVariables;
use App\Models\Template\Variables\StudentVariables;
use App\Models\User\Student\Student;
use Illuminate\Support\Collection;

class FeesReceiptTemplate extends Template
{
    private ?School $institute = null;
    private ?Student $student = null;
    private ?FeeCollectionRecord $record = null;

    public function bind(School $institute, Student $student, FeeCollectionRecord $record): void
    {
        $this->institute = $institute;
        $this->student = $student;
        $this->record = $record;
    }

    public function variableOperations(bool $preview = false): Collection
    {
        if ($preview && !$this->record) {
            $this->record = $this->dummyFeeRecord();
        }

        $feesEntriesTable = view('templates.render-parts.fees_receipt_entries', ['record' => $this->record])->render();

        return collect(
            array_merge(
                [
                    new InstituteVariables($this->institute),
                    new StudentVariables($this->student),
                    new FeesReceiptVariables($this->record, $feesEntriesTable),
                ]
            )
        );
    }

    private function dummyFeeRecord(): FeeCollectionRecord
    {
        $record = FeeCollectionRecord::make();
        $record->display_id = '1234';
        $record->school_id = 1;
        $record->branch_id = 1;
        $record->enrollment_id = 1;
        $record->session_id = 1;
        $record->entry_date = now()->toDateString();

        $record->entries = collect(
            [
                FeeCollectionRecordEntry::make(
                    [
                        'fee_head_id'   => 1,
                        'month_year'    => now()->startOfMonth()->toDateString(),
                        'actual_amount' => 1234,
                        'amount'        => 1234,
                        'waived_amount' => 12,
                        'paid_amount'   => 34,
                    ]
                ),
            ]
        );

        return $record;
    }
}
