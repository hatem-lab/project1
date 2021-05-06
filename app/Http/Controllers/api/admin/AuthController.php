<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Auth;
class AuthController extends Controller
{
    use GeneralTrait;
    public function login(Request $request)
        {
          try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                 'email' => 'required',
                'password' => 'required|string|min:6',
            ]);

           if($validator->fails())
           {
               $code= $this->returnCodeAccordingToInput($validator);
               return $this->returnValidationError($code,$validator);
           }



           $credentials = $request->only('email', 'password');
           $token=Auth::guard('admin-api')->attempt($credentials);
           if (! $token )
            {
            return $this->returnError('400','فشلت عملية الدخول');
            }

            return $this->returnData('token',$token,'تم الدخول بنجاح');
          }

          catch(\Expection $e)
          {
              return $this->returnError($e->getCode(),$e->getMessage());
          }

            $credentials = $request->only('email', 'password');

            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return $this->returnError('400','فشلت عملية الدخول');
                }
            } catch (JWTException $e) {
                return $this->returnError('500','could_not_create_token');

            }
            return $this->returnData('category',$data,'تم جلب البيانات بنجاح');

            return response()->json(compact('token'));
        }



        ///logout///
        public function logout(Request $request)
        {
               $token= $request->header('auth_token');
                if($token)
                {
                    JWTAuth::setToken( $token)->invalidate();
                    return $this->returnSuccessMessage('You have successfully logged out.');
                }

                else
                {
                    return $this->returnError('E1000','Failed to logout, please try again.');
                }

        }
}
