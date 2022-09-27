<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'short_description.*' => 'string|max:500|nullable',
            // 'issue_date.*' => 'required',
            // 'expiry_date.*' => 'required',
            'image.*'   => 'mimes:jpg,jpeg,bmp,png,gif,svg,pdf,PDF,JPG,JPEG,PNG,GIF,doc,docx,DOC,DOCX|max:5120',
        ];
        // if($this->input('img_req')){
        //     $nbr = count($this->input('img_req')) - 1;
        // }else{
        //     $nbr =0;
        // }

        // foreach(range(0, $nbr) as $index) {
        //     $rules['image.' . $index] = 'required|mimes:jpg,jpeg,bmp,png,gif,svg,pdf,PDF,JPG,JPEG,PNG,GIF,doc,docx,DOC,DOCX|max:5120';
        // }

        //cat_id
        if($this->input('certification_id_req')){
            $cc_id = count($this->input('certification_id_req')) - 1;
        }else{
            $cc_id =0;
        }

        foreach(range(0, $cc_id) as $index) {
            $rules['certification_id.' . $index] = 'required';
        }

        return $rules;

    }

    // public function messages()
    // {
    //     return [
    //         'image.*.required' => 'image is required',
    //     ];
    // }

}
