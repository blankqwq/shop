<?php

namespace App\Http\Requests;



use Illuminate\Validation\Rule;

class SendReviewRequest extends Request
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reviews'=>['array','required'],
            'reviews.*.id'=>[
                'required',
                Rule::exists('order_items','id')->where('order_id',$this->route('order')->id)
            ],
            'reviews.*.rating'=>['required','integer','min:1'],
            'reviews.*.review'=>['required']
        ];
    }
    public function attributes()
    {
        return [
            'reviews.*.rating' => '评分',
            'reviews.*.review' => '评价',
        ];
    }
}
