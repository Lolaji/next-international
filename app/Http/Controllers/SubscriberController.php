<?php

namespace App\Http\Controllers;

use App\Subscribers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SubscriberController extends Controller {

    public function create (Request $request) {

        $response = ['success' => false, 'message' => []];

        $data = $request->all();

        $message = [
            'email.unique' => 'This :attribute already exist in our subscription list'
        ];

        $validate = Validator::make($data, [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|unique:subscribers'
        ], $message);

        if (!$validate->fails()) {
            if (Subscribers::create($data)) {
                $response['success'] = true;
                $response['message'] = 'You have successfully subscribe';
            } else {
                $response['success'] = true;
                $response['message'] = 'Unable to subscribe due to system error. Please, try again later.';
            }
        } else {
            $response['success'] = false;
            foreach ($data as $key => $value) {
                $response['message'][$key] = $validate->errors()->first($key);
            }
        }
        return $response;
    }

    public function fetch () {
        return Subscribers::latest()->get();
    }

    public function remove (Subscribers $subscriber) {
        $response = ['success'=>false, 'message'=>''];
        if ($subscriber->delete()) {
            $response['success'] = true;
            $response['message'] = 'Subscriber deleted Successfully';
        } else {
            $response['success'] = false;
            $response['message'] = 'Unable to delete subscriber due to system error. Please, try again.';
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
