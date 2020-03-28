<?php

namespace App\Http\Controllers;

use App\Tags;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TagsController extends Controller {

    /**
     * Store and update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tags  $tag_id
     * @return \Illuminate\Http\Response
     */
    public function upsert(Request $request) {
        $response = ['success'=>false, 'message'=>[]];

        $message = [
            'title.unique' => 'This title is already exist'
        ];

        $uniqueValidateValue = (!is_null($request->post('id')) && ( $request->post('original_title') == $request->post('title') ))?'' : '|unique:tags';

        $validate = Validator::make($request->all(), [
            'title' => 'required'.$uniqueValidateValue,
            'description' => 'required'
        ], $message);

        $post_data = $request->all();
        // remove original_title element from $post_data
        // for database operation.
        unset($post_data['original_title']);

        if (!$validate->fails()) {
            
            if (!is_null($post_data['id'])) {
                if (Tags::find($post_data['id'])->update($post_data)) {
                    $response['success'] = true;
                    $response['message'] = 'Tag updated successfully';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Unable to update tag due to system error. Please, try again.';
                }
            } else {
                if ($tag = Tags::create($post_data)) {
                    $response['success'] = true;
                    $response['message'] = 'Tag added successfully';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Unable to add tag due to system error. Please, try again.';
                }
            }
            
        } else {
            $response['success'] = false;
            foreach ($post_data as $key => $value) {
                $response['message'][$key] = $validate->errors()->first($key);
            }
        }
        return $response;
    }

    public function fetch () {
        return Tags::latest()->get();
    }

    public function get ($tag_id) {
        return Tags::find($tag_id);
    }

    public function remove (Tags $tag) {
        $response = ['success'=>false, 'message'=>''];
        if ($tag->delete()) {
            $response['success'] = true;
            $response['message'] = 'Tag deleted successfully';
        } else {
            $response['success'] = false;
            $response['message'] = 'Unable to delete tag due to system error. Please, try again.';
        }
        return $response;
    }

    public function destroyMany ($ids) 
    {
        $response = ['success'=>false, 'num_deleted_rows'=>0];
        $arr_id = explode(',', $ids);

        if ($num_rows = Tags::destroy($arr_id)) {
            $response['success'] = true;
            $response['num_deleted_rows'] = $num_rows;
        }

        return $response;
        
    }
}
