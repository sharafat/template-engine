<style>
    #fees-records th,
    #fees-records td {
        text-align: center;
        vertical-align: middle;
    }

    #fees-records tbody .col-particulars {
        text-align: left;
    }
    #fees-records tbody .col-actual-amount,
    #fees-records tbody .col-payable-amount,
    #fees-records tbody .col-waived-amount,
    #fees-records tbody .col-paid-amount,
    #fees-records tbody .col-due-amount {
        text-align: right;
    }
</style>

<table id="fees-records">
    <thead>
    <tr>
        <th class="col-serial">No.</th>
        <th class="col-particulars">Particulars</th>
        <th class="col-details">Details</th>
        <th class="col-actual-amount">Actual Amount</th>
        <th class="col-pay-method">Payment Method</th>
        <th class="col-payable-amount">Payable Amount</th>
        <th class="col-waived-amount">Waived</th>
        <th class="col-paid-amount">Paid</th>
        <th class="col-due-amount">Due</th>
    </tr>
    </thead>
    <tbody>
    @php($decimalDigits = 0)
    @php($noPaisaSymbol = '/-')
    @foreach($record->entries as $entry)
        <tr>
            <td class="col-serial">{{ $loop->index + 1 }}</td>
            <td class="col-particulars">
                <div class="head-name">{{ $entry->head->name }}</div>
                @if (!empty($entry->notes) || !empty($entry->due_from_receipt_id))
                    <small class="notes">
                        @if (!empty($entry->due_from_receipt_id))
                            Due in
                            <a target="_blank"
                               href="{{ route('fees.collections.receipt', $entry->due_from_receipt_id ) }}">
                                {{ $entry->dueFromReceipt->display_id ?? $entry->due_from_receipt_id }}
                            </a>
                        @endif
                        @if (!empty($entry->notes) && !empty($entry->due_from_receipt_id))
                            <br/>
                        @endif
                        {{ $entry->notes }}
                    </small>
                @endif
            </td>
            <td class="col-details">
                {{ $entry->formatted_month_year ?? $entry->getFormattedMonthYear() }}
            </td>
            <td class="col-actual-amount">
                {!! $entry->actual_amount > 0
                        ? number_format($entry->actual_amount, $decimalDigits) . $noPaisaSymbol
                        : '' !!}
            </td>
            <td class="col-pay-method">
                @if ($entry->bank_account_id)
                    {{ $entry->bankAccount->bank_name_short }}
                    <br/>
                    <small>
                        <span>{{ carbonToLocalDateFormat($entry->bank_transaction_date) }}</span>
                        <br/>
                        <span>{{ $entry->bank_transaction_id }}</span>
                    </small>
                @else
                    {{ $entry->paymentMethod?->name }}
                @endif
            </td>
            <td class="col-payable-amount">
                {{ number_format($entry->amount, $decimalDigits) }}{!! $noPaisaSymbol !!}
            </td>
            <td class="col-waived-amount">
                {!! $entry->waived_amount
                        ? number_format($entry->waived_amount, $decimalDigits) . $noPaisaSymbol
                        : '' !!}
            </td>
            <td class="col-paid-amount">
                {{ number_format($entry->paid_amount, $decimalDigits) }}{!! $noPaisaSymbol !!}
            </td>
            <td class="col-due-amount">
                {{ number_format($entry->dueAmount(), $decimalDigits) }}{!! $noPaisaSymbol !!}
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th class="col-total-label" colspan="5">Total</th>
        <th class="col-payable-amount">
            {{ number_format($record->entries->sum('amount'), $decimalDigits) }}{!! $noPaisaSymbol !!}
        </th>
        <td class="col-waived-amount">
            {{ number_format($record->entries->sum('waived_amount'), $decimalDigits) }}{!! $noPaisaSymbol !!}
        </td>
        <td class="col-paid-amount">
            {{ number_format($record->entries->sum('paid_amount'), $decimalDigits) }}{!! $noPaisaSymbol !!}
        </td>
        <td class="col-due-amount">
            {{ number_format($record->entries->sum->dueAmount(), $decimalDigits) }}{!! $noPaisaSymbol !!}
        </td>
    </tr>
    </tfoot>
</table>
