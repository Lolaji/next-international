<?php

namespace App\Http\Controllers;

use App\Posts;
use App\Services;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Boolean;

class postController extends Controller {

    /**
     *  Create and Update post
     * 
     */
    public function upsert (Request $request) {
        $response = ['success' => false, 'message' => [], 'post_title'=>null];

        $reqData = $request->post();
        // implode the tags array with ';' character if tags 
        // from the request array is not null
        if (!is_null($reqData['tags']) && is_array($reqData['tags']))
            $reqData['tags'] = implode(';', $reqData['tags']);


        $isExitValue = (!empty($reqData['id']) && $reqData['title'] == $reqData['original_title'])? '' : '|unique:posts';

        $message = [
            'title.unique' => 'This title is already exist'
        ];

        $validate = Validator::make($request->all(), [
            'title' => 'required'.$isExitValue,
            'tags' => 'required',
            'category' => 'required',
            'short_desc' => 'required',
            'keywords' => 'required',
            'content' => 'required'
        ], $message);
        
        // remove original_title from the request array
        unset($reqData['original_title']);

        if (!$validate->fails()) {
            $userPosts = Auth::user()->posts;
            // checks if a new image is selected for upload
            if ( ! empty ($userPosts->find($reqData['id'])->header_image) && ($userPosts->find($reqData['id'])->header_image != $reqData['header_image'])) {
                Storage::delete('public/images/post/'.$userPosts->find($reqData['id'])->header_image);
            }

            if (!empty($reqData['id'])) {
                if ( $userPosts->find($reqData['id'])->update($reqData) ) {
                    $response['post_title'] = str_replace(' ', '-', strtolower($reqData['title']));
                    $response['success'] = true;
                    $response['message'] = 'Post successfully updated';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Unable to unable post due to system error. Please, try again later.';
                }
            } else {
                if ( Auth::user()->posts()->create($reqData) ) {
                    $response['post_title'] = str_replace(' ', '-', strtolower($reqData['title']));
                    $response['success'] = true;
                    $response['message'] = 'Post successfully created';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Unable to create post due to system error. Please, try again later.';
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

    public function fetchAll () {
        return Posts::latest()->get();
    }

    public function delete (Posts $post) {
        $response = ['success'=>false, 'message'=>''];
        $post_image = $post->header_image;
        $response['image'] = $post_image;
        if ($post->delete()) {
            Storage::delete('public/images/post/'.$post_image);
            $response['success'] = true;
            $response['message'] = 'Post deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Unable to delete post due to system error. Please, try again.';
        }

        return $response;
    }

    public function destroyMany ($ids) 
    {
        $response = ['success'=>false, 'num_deleted_rows'=>0];
        $arr_id = explode(',', $ids);

        $images = [];
        
        for($i=0; $i<count($arr_id);$i++) {
            $image = Posts::find($arr_id[$i])->header_image;
            Storage::delete('public/images/post/'.$image);
        }

        if ($num_rows = Posts::destroy($arr_id)) {
            $response['success'] = true;
            $response['num_deleted_rows'] = $num_rows;
        }

        return $response;
        
    }
}
