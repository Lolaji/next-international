<?php

namespace App\Http\Controllers;

use App\SiteSettings;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function changeMaintenanceMode (Request $request) {
        $response = ['success'=>false, 'message'=>''];

        $data = $request->all();

        if (SiteSettings::where('name', 'maintenance')->first()->update($request->all())) {
            $response['success'] = true;
            if ($data['value'] == 1)
                $response['message'] = 'Maintenance mode activated.';
            else 
                $response['message'] = 'Maintenance mode de-activated.';
        } else {
            $response['success'] = false;

            if ($data['value'] == 1)
                $response['message'] = 'Unable to activate the maintenance mode.';
            else 
                $response['message'] = 'Unable to de-activate the maintenance mode.';
        }
        return $response;
    }
}
