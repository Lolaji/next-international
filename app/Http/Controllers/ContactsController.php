<?php

namespace App\Http\Controllers;

use App\Contacts;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ContactsController extends Controller {

    public function send (Request $request) {
        $response = ['success'=> false, 'message'=>[]];
        
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required|max:100',
            'zip_code' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);

        $data = $request->all();
        
        if (!$validate->fails()) {
            if (Contacts::create($data)) {
                $response['success'] = true;
                $response['message'] = 'Contact sent successfully';
            } else {
                $response['success'] = false;
                $response['message'] = 'Unable to send contact due to system error. Please, try again later';
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
        return Contacts::latest()->get();
    }

    public function remove (Contacts $contact) {
        
        $response = ['success'=>false, 'message'=>''];
        if ($contact->delete()) {
            $response['success'] = true;
            $response['message'] = 'Contact deleted successfully';
        } else {
            $response['success'] = false;
            $response['message'] = 'Unable to delete contact due to system error. Please, try again';
        }
        return $response;
    }

    public function destroyMany ($ids) 
    {
        $response = ['success'=>false, 'num_deleted_rows'=>0];
        $arr_id = explode(',', $ids);

        if ($num_rows = Contacts::destroy($arr_id)) {
            $response['success'] = true;
            $response['num_deleted_rows'] = $num_rows;
        }

        return $response;
        
    }

}
