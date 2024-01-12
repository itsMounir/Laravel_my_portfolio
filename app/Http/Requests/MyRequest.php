<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\MyTrait;


class MyRequest extends FormRequest
{
    use MyTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            's_name' => ['required','unique:products,s_name','min:3','max:255'],
            't_name'=> ['required','min:3','max:255'],
            'category'=> ['required','min:3','max:255'],
            'company_name'=> ['required','unique:products,company_name','min:3','max:255'],
            'amount'=> ['required'],
            'ending_date'=> ['required'],
            'price'=> ['required']
        ];
    }


}
