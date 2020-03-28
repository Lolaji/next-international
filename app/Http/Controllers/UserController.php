<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller {
    
    public function login (Request $request) {
        $response = ['success' => false, 'message' => []];

        $data = $request->all();

        $validate = Validator::make($data, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!$validate->fails()) {
            if (Auth::attempt(['email'=>$data['email'], 'password'=> $data['password'], 'is_admin'=>1])) {
                $response['success'] = true;
                $response['message'] = 'Login successful';
            } else {
                $response['success'] = false;
                $response['message'] = 'Email/Password does not match or not authorize to access this page';
            }
        } else {
            $response['success'] = false;
            foreach ($data as $key => $value) {
                $response['message'][$key] = $validate->errors()->first($key);
            }
        }
        return $response;
    }

    public function update (Request $request) {
        $response = ['success'=>false, 'message'=>[]];

        $data = $request->all();

        $validate = Validator::make($data, [
            'email' => 'required',
            'username' => 'required'
        ]);

        if (!$validate->fails()) {
            if (Auth::user()->image != $data['image']) {
                Storage::delete('public/images/profile/'.Auth::user()->image);
            }

            if (Auth::user()->update($data)) {
                $response['success'] = true;
                $response['message'] = 'Profile updated successfully!';
            } else {
                $response['success'] = false;
                $response['message'] = 'Unable to upload profile due to system error. Please try again.';
            }
        } else {
            $response['success'] = false;
            foreach ($request->all() as $key => $value) {
                $response['message'][$key] = $validate->errors()->first($key);
            }
        }
        return $response;
        
    }

    public function logout () {
        Auth::logout();
        return redirect('auth/login');
    }
}
