<?php

namespace App\Http\UseCases;

use App\Http\Utils\FormatString;

class NoveltySetControlRegisterCase
{
    const REGISTER_TYPE = '08';
    /**
     * Generate set control register content for novelty file
     * @author Neil David Sanchez Quintana
     * @return void
     */
    public static function generate($total_register = '---------', $set_number = '----')
    {
        $total_value = str_repeat('0', 18);
        $reserved_white_spaces = str_repeat(' ', 187);
        $count = FormatString::fill($total_register, '0', 9);

        return self::REGISTER_TYPE . $count . $set_number . $total_value . $reserved_white_spaces . "\n";
    }
}
