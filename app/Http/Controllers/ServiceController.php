<?php

namespace App\Http\Controllers;

use App\Posts;
use App\Services;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function __construct () {}

    public function upsert (Request $request) {

        $response = ['success'=>false, "message"=>[]];

        // Custom message
        $custom_message = [
            'unique' => 'This :attribute is already exist.',
            'short_desc.required' => 'The short description field is required',
            'short_desc.max' => 'Short description must not greater than 100 character.',
            'title.max' => 'Title must not greater than 30 character.'

        ];

        $service = $request->post();

        $existValue = ($service['id'] && $service['title'] == $service['original_title'])? '' : '|unique:services';

        $validate = Validator::make($request->all(), [
            'title' => 'required|max:30'.$existValue,
            'short_desc' => 'required|max:100',
            'content' => 'required'
        ], $custom_message);

        unset($service['original_title']);

        if (!$validate->fails()) {

            // checks if a new image is selected for upload
            if ( ! empty (Services::find($service['id'])->overview_icon) && (Services::find($service['id'])->overview_icon != $service['overview_icon'])) {
                Storage::delete('public/images/service'.Services::find($service['id'])->overview_icon);
            }

            

            if ( ! empty (Services::find($service['id'])->header_image) && (Services::find($service['id'])->header_image != $service['header_image'])) {
                Storage::delete('public/images/service/'.Services::find($service['id'])->header_image);
            }
            
            if (!empty($service['id'])) {
                if (Services::find($service['id'])->update($service)) {
                    $response['success'] = true;
                    $response['message'] = 'Service updated successfully';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Unable to updated service due to systeom error. Please try again later.';
                }
            } else {
                if (Services::create($service)) {
                    $response['success'] = true;
                    $response['message'] = 'Service created successfully';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Unable to create service due to systeom error. Please try again later.';
                }
            }
        } else {
            $response['success'] = false;
            unset($service['id']);
            foreach ($service as $key => $value) {
                $response['message'][$key] = $validate->errors()->first($key);
            }
        }
        return $response;
    }

    public function fetchAll () {
        return Services::latest()->get();
    }

    public function delete (Services $service) {
        $response = ['success'=>false, 'message'=>''];
        $image = $service->header_image;
        if ($service->delete()) {
            Storage::delete('public/images/service/'.$image);
            $response['success'] = true;
            $response['message'] = 'Service deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Unable to delete service due to system error. Please, try again.';
        }

        return $response;
    }

    public function destroyMany ($ids) 
    {
        $response = ['success'=>false, 'num_deleted_rows'=>0];
        $arr_id = explode(',', $ids);

        $images = [];
        
        for($i=0; $i<count($arr_id);$i++) {
            $service = Services::find($arr_id[$i]);
            $images[$i] = [
                $service->header_image,
                $service->overview_icon
            ];
        }

        return $images;

        if ($num_rows = Services::destroy($arr_id)) {
            $response['success'] = true;
            $response['num_deleted_rows'] = $num_rows;
        }

        return $response;
        
    }
}
