<?php

namespace App\Http\UseCases;

use App\Http\Utils\FormatString;

class GenerateCashingRegisterControlCase
{
    const REGISTER_TYPE_SET = '08';
    const REGISTER_TYPE_FILE = '08';
    /**
     * Generate set control register content for novelty file
     * @author Neil David Sanchez Quintana
     * @return void
     */
    public static function index($deferred_payments)
    {
        $content = '';
        $totalCount = FormatString::fill($deferred_payments->count(), '0', 9);
        $totalAmountLot = FormatString::fill(number_format($deferred_payments->sum('amount'), 2, '', ''), '0', 18);
        $totalAmountAditional = FormatString::fill('0', '0', 18);
        $totalWhiteSpaceReserved = FormatString::fill(' ', ' ', 173);

        $content .= implode([
            '08',
            $totalCount,
            $totalAmountLot,
            $totalAmountAditional,
            '0001',
            $totalWhiteSpaceReserved,
            "\n"
        ]);

        $content .= implode([
            '09',
            $totalCount,
            $totalAmountLot,
            $totalAmountAditional,
            $totalWhiteSpaceReserved
        ]);

        return $content;
    }
}
