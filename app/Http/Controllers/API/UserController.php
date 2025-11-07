<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function login(Request $request)
    {

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // remember me
        if($request->remember_me){
            JWTAuth::factory()->setTTL(60 * 24 * 7); // 7 days
        }

        // attempt to login
        $token = JWTAuth::attempt($credentials);
        // get user 
        $user = Auth::user();

        // ກວດເບີ່ງວ່າ token ໄດ້ສ້າງຂຶ້ນມາບໍ່
        if(!$token){
            return response()->json([
                'success' => false,
                'message' => 'ອີເມວລ໌ ຫຼື ລະຫັດຜ່ານ ບໍ່ຖືກຕ້ອງ'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ]);

           
    }
}
