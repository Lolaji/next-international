<?php

namespace App\Http\Controllers;

use App\SiteInfo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SiteInfoController extends Controller
{
    
    public function __construct() {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SiteInfo  $siteInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $reponse = ['success' => false, 'message' => []];

        $data = $request->all();

        $validate = Validator::make($data, [
            'phone' => 'required',
            'contact_email_address' => 'required',
            'location' => 'required',
            'site_short_description' => 'required'
        ]);

        
        if ( ! $validate->fails() ) {
            foreach ($data as $key => $value) {
                if (SiteInfo::where('name', $key)->update(['content' => $value])) {
                    $reponse['success'] = true;
                    $reponse['message'] = 'Information updated successfully.';
                } else {
                    $reponse['success'] = false;
                    $reponse['message'] = 'Unable to update information due to system error. Please try again';
                }
            }
        } else {
            $reponse['success'] = false;
            foreach ($data as $key => $value) {
                $reponse['message'][$key] = $validate->errors()->first($key);
            }
        }
        return $reponse;
    }

}
