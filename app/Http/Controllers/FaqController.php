<?php

namespace App\Http\Controllers;

use App\Faq;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FaqController extends Controller {

    public function upsert (Request $request) {
        $response = ['success'=> false, 'message'=>[]];

        $message = [
            'question.unique' => 'This question already exist'
        ];

        $uniqueValidateValue = (!is_null($request->post('id')) && ( $request->post('original_question') == $request->post('question') ))?'' : '|unique:faqs';
        
        $validate = Validator::make($request->all(), [
            'question' => 'required'.$uniqueValidateValue,
            'answer' => 'required|max:100',
            'position' => 'required'
        ], $message);

        $data = $request->all();

        unset($data['original_question']);
        
        if (!$validate->fails()) {
            if (!is_null($data['id'])) {
                if (Faq::find($data['id'])->update($data)) {
                    $response['success'] = true;
                    $response['message'] = 'FAQ updated successfully';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Unable to update FAQ due to system error. Please, try again later';
                }
            } else {
                if (Faq::create($data)) {
                    $response['success'] = true;
                    $response['message'] = 'FAQ created successfully.';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Unable to create FAQ due to system error. Please, try again later';
                }
            }
        } else {
            $response['success'] = false;
            foreach ($request->all() as $key => $value) {
                $response['message'][$key] = $validate->errors()->first($key);
            }
        }

        return $response;
    }

    public function fetch () {
        return Faq::orderBy('position')->get();
    }

    public function remove (Faq $faq) {
        $response = ['success' => false, 'message' => ''];
        if ($faq->delete()) {
            $response['success'] = true;
            $response['message'] = 'FAQ deleted successfully';
        } else {
            $response['success'] = false;
            $response['message'] = 'Unable to delete FAQ due to system error. Please, try again.';
        }

        return $response;
    }

    public function destroyMany ($ids) 
    {
        $response = ['success'=>false, 'num_deleted_rows'=>0];
        $arr_id = explode(',', $ids);

        if ($num_rows = Faq::destroy($arr_id)) {
            $response['success'] = true;
            $response['num_deleted_rows'] = $num_rows;
        }

        return $response;
        
    }
    
}
