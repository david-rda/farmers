<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Interfaces\ICheckFarmer;

class FarmerController extends Controller implements ICheckFarmer
{
    /**
     * ფერმერზე ინფორმაციის წამოღების მეთოდი
     * @method POST,
     * @return json data
     * @param Request
     */
    public function getFarmerData(Request $request) {
        $registered = json_decode(Http::get('http://agroinsurance2020.mepa.gov.ge/test_service/CURL?personal_id='. $request->personal));

        return response()->json([
            "data" => $registered
        ], 200);
    }

    /**
     * ფერმერზე რეგისტრაციის გადამოწმების მეთოდი
     * @method POST,
     * @return json data
     * @param Request
     */
    public function checkFarmer(Request $request) {
        $this->validate($request, [
            "personal" => "required|min:9|max:11"
        ]);
        
        $login = 'agrocredit';
        $password = '!4groCred1t_p';
        
        $url = 'https://maps.mepa.gov.ge/dbgis-proxy/api/rest_tl_data/agro_credit/check_interview_status?frn='.urlencode($request->personal);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $beneficiary = json_decode(curl_exec($ch));
        curl_close($ch);
        
        if($beneficiary == NULL) {
            return response()->json([
                "errors" => [
                    "error" => [
                        "ინფორმაციის შემოწმებისას დაფიქსირდა შეცდომა."
                    ]
                ]
            ], 422);
        } else {
            if($beneficiary->services[0]->entities[0]->is_valid == '1') {
                return response()->json([
                    "status" => 1
                ]);
            } else {
                return response()->json([
                    "status" => 0
                ]);
            }
        }
    }
}
