<?php

namespace App\Classes;

class ResponseFile
{
    /**
     * Get header content in file
     *
     * @author Cristian Machado
     * @param [type] $content
     * @return void
     */
    public function prepareToReadFile($content)
    {
        // $this->getHeaderFile($content[0]);
        // $this->getHeaderLot($content[1]);
        // $this->getFooterLot($content[count($content) - 2]);
        // $this->getFooterFile($content[count($content) - 1]);

        // foreach ($file as $key => $value) {
        //     if ($key > 1 && $key < count($file) - 2) $this->getContent($value);
        // }
    }

    /**
     * Get header content in file
     *
     * @author Cristian Machado
     * @param [type] $content
     * @return void
     */
    public function getHeaderFile($content)
    {
        $type_of_register = substr($content, 0, 2);
        $did_main_collector_company = substr($content, 2, 10);
        $name_company = substr($content, 12, 16);
        $financial_entity_code = substr($content, 28, 3);
        $file_date = substr($content, 31, 8);
        $file_recording_date = substr($content, 39, 4);
        $modifier = substr($content, 43, 1);
        $reserved = substr($content, 44, 176);
    }

    /**
     * Get lot content in file
     *
     * @author Cristian Machado
     * @param [type] $content
     * @return void
     */
    public function getHeaderLot($content)
    {
        $type_of_register = substr($content, 0, 2);
        $billed_service_code = substr($content, 2, 13);
        $number_of_lot = substr($content, 15, 4);
        $description_of_the_billed_service = substr($content, 19, 15);
        $reserved = substr($content, 34, 186);
    }

    /**
     * Get content in file
     *
     * @author Cristian Machado
     * @param [type] $content
     * @return void
     */
    public function getContent($content)
    {
        $type_of_register = substr($content, 0, 2);
        $code_type_of_register = substr($content, 2, 2);
        $primary_user_reference = substr($content, 4, 48);
        $secondary_reference_of_the_user = substr($content, 52, 30);
        $efr_id = substr($content, 82, 8);
        $paying_customer_account_number = substr($content, 90, 17);
        $paying_customer_account_type = substr($content, 107, 2);
        $did_customer = substr($content, 109, 10);
        $name_customer = substr($content, 119, 22);
        $maximum_debit_value = substr($content, 141, 14);
        $effective_date_of_the_transaction = substr($content, 155, 8);
        $sequence = substr($content, 163, 7);
        $response_code = substr($content, 170, 3);
        $reserved = substr($content, 173, 47);
    }

    /**
     * Get footer lot content in file
     *
     * @author Cristian Machado
     * @param [type] $content
     * @return void
     */
    public function getFooterLot($content)
    {
        $type_of_register = substr($content, 0, 2);
        $total_batch_records = substr($content, 2, 9);
        $number_of_lot = substr($content, 11, 4);
        $total_value = substr($content, 15, 18);
        $reserved = substr($content, 33, 187);
    }

    /**
     * Get footer content in file
     *
     * @author Cristian Machado
     * @param [type] $content
     * @return void
     */
    public function getFooterFile($content)
    {
        $type_of_register = substr($content, 0, 2);
        $total_batch_records = substr($content, 2, 9);
        $total_value = substr($content, 11, 18);
        $reserved = substr($content, 29, 191);
    }
}
