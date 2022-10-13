<?php

namespace App\Http\UseCases;

use App\Http\Utils\FormatString;

class NoveltyControlRegisterCase
{
    const REGISTER_TYPE_SET = '08';
    const REGISTER_TYPE_FILE = '08';
    /**
     * Generate set control register content for novelty file
     * @author Neil David Sanchez Quintana
     * @return void
     */
    public static function generate($total_register = '---------', $set_number = '----')
    {
        $content = '';
        $total_value = str_repeat('0', 18);
        $reserved_white_spaces_set = str_repeat(' ', 187);
        $reserved_white_spaces_file = str_repeat(' ', 191);
        $count = FormatString::fill($total_register, '0', 9);
        $content = self::REGISTER_TYPE_SET . $count . $set_number . $total_value . $reserved_white_spaces_set . "\n";
        $content .= self::REGISTER_TYPE_FILE . $count . $total_value . $reserved_white_spaces_file;

        return $content;
    }
}
