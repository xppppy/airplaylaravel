<?php

namespace App\Http\Requests\Api;

//用于修改消息验证
class VideoRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => 'sometimes|max:50',
            'title'      => 'required|max:50',
            'thum'       => 'sometimes|url',
            'sum'        => 'sometimes|integer|min:1|max:10000',
            'number'     => 'sometimes|integer',
            'playerUrl'  => 'sometimes|url',
            'type_id'    => 'required|integer',
        ];
    }
}
