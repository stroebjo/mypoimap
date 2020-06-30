<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlace extends FormRequest
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
            'user_category_id' => 'required|exists:App\UserCategory,id',
            'title' => 'required',
            'priority' => 'required|integer|min:0,max:5',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'url'  => 'nullable|url',
            'wikipedia_url' => 'nullable|url',
            'google_place_id' => '', // who knows what's the spec for this thing...
            'unesco_world_heritage' => 'nullable|integer',
            'description' => '',
        ];
    }
}
