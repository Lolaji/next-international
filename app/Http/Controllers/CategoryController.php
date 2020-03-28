<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller {

    public function upsert (Request $request) {
        $response = ['success'=> false, 'message'=>[]];

        $message = [
            'title.unique' => 'This title is already exist'
        ];

        $uniqueValidateValue = (!is_null($request->post('id')) && ( $request->post('original_title') == $request->post('title') ))?'' : '|unique:categories';
        
        $validate = Validator::make($request->all(), [
            'title' => 'required'.$uniqueValidateValue,
            'description' => 'required|max:100'
        ], $message);

        $data = $request->all();

        unset($data['original_title']);
        
        if (!$validate->fails()) {
            
            if (!is_null($data['id'])) {
                if (Category::find($data['id'])->update($data)) {
                    $response['success'] = true;
                    $response['message'] = 'Category updated successfully';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Unable to update category due to system error. Please, try again later';
                }
            } else {
                return $data;
                if (Category::create($data)) {
                    $response['success'] = true;
                    $response['message'] = 'Category created successfully.';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Unable to create category due to system error. Please, try again later';
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
        return Category::latest()->get();
    }

    public function remove (Category $category) {
        $response = ['success'=>false, 'message'=>''];
        if ($category->delete()) {
            $response['success'] = true;
            $response['message'] = 'Category deleted successfully';
        } else {
            $response['success'] = false;
            $response['message'] = 'Unable to delete category due to system error. Please, try again.';
        }
        return $response;
    }

    public function destroyMany ($ids) 
    {
        $response = ['success'=>false, 'num_deleted_rows'=>0];
        $arr_id = explode(',', $ids);

        if ($num_rows = Category::destroy($arr_id)) {
            $response['success'] = true;
            $response['num_deleted_rows'] = $num_rows;
        }

        return $response;
        
    }

}
