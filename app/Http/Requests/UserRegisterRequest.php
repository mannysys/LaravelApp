<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRegisterRequest extends Request
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
        //表单提交数据规则校验
        return [
            'name'=>'required|min:3',
            'email'=>'required|email|unique:users,email', // 指定是users表中的email字段唯一性
            'password'=>'required|min:6|confirmed', //第2次密码确认
            'password_confirmation'=>'required|min:6',
        ];
    }
}
