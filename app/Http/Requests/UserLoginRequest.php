<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserLoginRequest extends Request
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
        return [
            'email'=>'required|email', // 指定是users表中的email字段唯一性
            'password'=>'required|min:6', //第2次密码确认
        ];
    }
}
