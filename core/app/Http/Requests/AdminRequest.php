<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'name' => 'required|between:5,23',
            'description' => 'required|between: 1,250',
            'image' => 'required',
            'url' => 'url',                         
            'price' => [
                'required',
                'regex:/\d+[\.|,]?\d+/'
            ],
        ];
       
        return $rules;
        

    }

    public function messages() {
        return [
           'required' => 'Ce champs est requis',
           'url' => 'Cette URL n\'est pas valide',
           'betwwen' => "ce :attribute doit comporter entre :min et :max caractères",
        ];
    }

    public function validator(\Illuminate\Validation\Factory $factory)
    {
        \Validator::extend('nonEmptyArray', function($attribute, $value, $parameters) {
            return ( is_array($value) && count(array_filter($value)) > 0 );
        });

        $validator = $factory->make(
            $this->all(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes()
        );
            
        return $validator;
    }

    
}

