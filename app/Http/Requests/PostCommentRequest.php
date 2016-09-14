<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostCommentRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    //授权用户访问该请求
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    //用户请求验证规则
    public function rules()
    {
        return [
            'body'=>'required',
            'discussion_id'=>'required'
        ];
    }
}
