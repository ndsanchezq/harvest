<?php

namespace App\Classes;

use App\Models\MyBodyTech\PaymentMethod;
use App\Models\File;

class ResponseFile
{
    private $type, $file_name, $file_size, $file_lines, $file_type, $file_modifier, $file_delivery_date;

    /**
     * Get header content in file
     *
     * @author Cristian Machado
     * @param [type] $content
     * @return void
     */
    public function prepareToReadFile($file)
    {
        // Get file
        $content = file($file->getPathname());

        // Validate content not empty or less 4
        if (count($content) <= 4) {
            throw new \Exception('El archivo no es valido.');
        }

        // Type true: Novedades false: Cobros
        $this->type = strlen($content[0]) - 2 >= 220;

        // Set values
        $this->file_name = $file->getClientOriginalName();
        $this->file_size = $file->getSize();
        $this->file_lines = count($content);
        $this->file_type = $this->type ? 'novedad' : 'cobro';

        // Iterate header and footer of file
        $this->getHeaderFile($content[0]);
        $this->getHeaderLot($content[1]);
        $this->getFooterLot($content[count($content) - 2]);
        $this->getFooterFile($content[count($content) - 1]);

        // Iterate detail of file
        foreach ($content as $key => $value) {
            if ($key > 1 && $key < count($content) - 2) $this->getContent($value);
        }

        // Generate file
        $this->saveFile($file);
    }
    /**
     * Get header content in file
     *
     * @author Cristian Machado
     * @param string $content
     * @return void
     */
    public function getHeaderFile($content)
    {
        $type_of_register = substr($content, 0, 2);
        $did_main_collector_company = substr($content, 2, 10);

        if ($this->type) {
            $name_company = substr($content, 12, 16);
            $financial_entity_code = substr($content, 28, 3);
            $file_date = substr($content, 31, 8);
            $file_recording_date = substr($content, 39, 4);
            $modifier = substr($content, 43, 1);
            $reserved = substr($content, 44, 176);
        } else {
            $collection_date = substr($content, 12, 8);
            $financial_entity_code = substr($content, 20, 3);
            $account_number = substr($content, 23, 17);
            $file_date = substr($content, 40, 8);
            $file_recording_date = substr($content, 48, 4);
            $modifier = substr($content, 52, 1);
            $account_type = substr($content, 53, 2);
            $reserved = substr($content, 55, 107);
        }

        $this->file_modifier = $modifier;
        $this->file_delivery_date = $file_date;
    }

    /**
     * Get lot content in file
     *
     * @author Cristian Machado
     * @param string $content
     * @return void
     */
    public function getHeaderLot($content)
    {
        $type_of_register = substr($content, 0, 2);
        if ($this->type) {
            $billed_service_code = substr($content, 2, 13);
            $number_of_lot = substr($content, 15, 4);
            $description_of_the_billed_service = substr($content, 19, 15);
            $reserved = substr($content, 34, 186);
        } else {
            $collected_service_code = substr($content, 2, 13);
            $number_of_lot = substr($content, 15, 4);
            $reserved = substr($content, 19, 143);
        }
    }

    /**
     * Get content in file
     *
     * @author Cristian Machado
     * @param string $content
     * @return void
     */
    public function getContent($content)
    {
        $type_of_register = substr($content, 0, 2);
        if ($this->type) {
            $code_type_of_register = substr($content, 2, 2);
            $primary_user_reference = (int) substr($content, 4, 48);
            $secondary_reference_of_the_user = substr($content, 52, 30);
            $efr_id = substr($content, 82, 8);
            $paying_customer_account_number = substr($content, 90, 17);
            $paying_customer_account_type = substr($content, 107, 2);
            $did_customer = substr($content, 109, 10);
            $name_customer = substr($content, 119, 22);
            $maximum_debit_value = substr($content, 141, 14);
            $effective_date_of_the_transaction = substr($content, 155, 8);
            $effective_date_of_the_transaction = now()->parse($effective_date_of_the_transaction)->format('Y-m-d');
            $sequence = substr($content, 163, 7);
            $response_code = substr($content, 170, 3);
            $reserved = substr($content, 173, 47);
        } else {
            $primary_user_reference = (int) substr($content, 2, 48);
            $collected_value = substr($content, 50, 14);
            $origin_of_payment = substr($content, 64, 2);
            $payment_method = substr($content, 66, 2);
            $operation_number = substr($content, 68, 6);
            $authorization_number = substr($content, 74, 6);
            $debited_financial_entity_code = substr($content, 80, 3);
            $branch_code = substr($content, 83, 4);
            $sequence = substr($content, 87, 7);
            $response_code = substr($content, 94, 3);
            $reserved = substr($content, 97, 65);

            $effective_date_of_the_transaction = now()->parse($this->file_delivery_date)->format('Y-m-d');
        }

        // // Recovery payment methods with customer_id
        // $payment_method = PaymentMethod::find($primary_user_reference);
        // if ($payment_method instanceof PaymentMethod) {
        //     if (isset(config('custom.response.errors')[$response_code])) {
        //         $payment_method->payment_method_validation_status = 'rechazada';
        //         $payment_method->payment_method_register_date = $effective_date_of_the_transaction;
        //         $payment_method->payment_method_reason_rejection = config('custom.response.errors')[$response_code];
        //     } else {
        //         $payment_method->payment_method_validation_status = 'validada';
        //         $payment_method->payment_method_validation_date = $effective_date_of_the_transaction;
        //     }
        //     $payment_method->save();
        // }
    }

    /**
     * Get footer lot content in file
     *
     * @author Cristian Machado
     * @param string $content
     * @return void
     */
    public function getFooterLot($content)
    {
        $type_of_register = substr($content, 0, 2);
        $total_batch_records = substr($content, 2, 9);

        if ($this->type) {
            $number_of_lot = substr($content, 11, 4);
            $total_value = substr($content, 15, 18);
            $reserved = substr($content, 33, 187);
        } else {
            $total_value_collected_in_lot = substr($content, 11, 18);
            $lot_number = substr($content, 29, 4);
            $reserved = substr($content, 33, 129);
        }
    }

    /**
     * Get footer content in file
     *
     * @author Cristian Machado
     * @param string $content
     * @return void
     */
    public function getFooterFile($content)
    {
        $type_of_register = substr($content, 0, 2);

        if ($this->type) {
            $total_batch_records = substr($content, 2, 9);
            $total_value = substr($content, 11, 18);
            $reserved = substr($content, 29, 191);
        } else {
            $total_records_collected_in_the_file = substr($content, 2, 9);
            $total_value_collected_on_file = substr($content, 11, 18);
            $reserved = substr($content, 29, 133);
        }
    }

    /**
     * Save data in file model
     *
     * @author Cristian Machado
     * @param File $files
     * @return void
     */
    public function saveFile($files)
    {
        // Craete register
        $file = new File;
        $file->name = $this->file_name;
        $file->path = 'BANCOLOMBIA/' . $this->file_name;
        $file->delivery_date = $this->file_delivery_date;
        $file->modifier = $this->file_modifier;
        $file->size = $this->file_size;
        $file->lines_number = $this->file_lines;
        $file->received = 1;
        $file->bank_id = 4;
        $file->file_type = $this->file_type;
        $file->file_status = 'completed';
        $file->save();

        // Storage
        $files->storeAs('BANCOLOMBIA', $this->file_name);
    }
}
