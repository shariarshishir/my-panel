<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ReadyStockPriceBreakDownRule implements Rule
{
     /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $request;
    public $product_type;
    public function __construct($request,$product_type)
    {
        $this->request = $request;
        $this->product_type = $product_type;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        if($this->product_type == 2 && (!isset($value) && !isset($this->request->full_stock))){
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute are required.';
    }
}
