<?php 
    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\Owner;
    use App\Models\DeletedAccount;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Tymon\JWTAuth\Facades\JWTAuth;

    class AuthController extends Controller
    {
        // to check mobile is exist or not
        public function checkNumber(Request $request)
        {
            try {
                $post = $request->all();
                $mandodary_params = array('phone');
                $validation = ParamValidation($mandodary_params, $post);
                if($validation[config('constants.RESPONSE_STATUS')] == config('constants.RESPONSE_FLAG_FAIL')) {
                    return response()->json($validation, config('constants.RESPONSE_FLAG_ERROR_CODE'));
                } else {
                    $count = Owner::where("phone",$post["phone"])->count();
                    $responseData = array(
                        'phone' => $post["phone"],
                        'is_phone_registered' => $count > 0 ? 1 : 0
                    );
                    return response()->json([
                        config('constants.RESPONSE_STATUS') => config('constants.RESPONSE_FLAG_SUCCESS_CODE'),
                        config('constants.RESPONSE_MESSAGE') => $count > 0 ? "Mobile No. found" : "Mobile No. not found",
                        config('constants.RESPONSE_DATA') => $responseData
                    ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                }
            } catch (\Exception $e) {
                return response()->json([
                    $data[config('constants.RESPONSE_STATUS')] => config('constants.RESPONSE_FLAG_FAIL'),
                    'message' => $e->getMessage(),
                    config('constants.RESPONSE_DATA') => (object) []
                ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
            }
        }

        // Register new user
        public function register(Request $request)
        {
            try {
                $post = $request->all();
                $mandodary_params = array('name','phone','gender','dob','password','device_token','device_type');
                $validation = ParamValidation($mandodary_params, $post);
                if($validation[config('constants.RESPONSE_STATUS')] == config('constants.RESPONSE_FLAG_FAIL')) {
                    return response()->json($validation, config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                } else {
                    $isPhoneExist = User::where("phone",$post["phone"])->count();
                    if($isPhoneExist == 0) {
                        $isError = 0;
                        $email = $request->email == "" ? null : $request->email;
                        if($email != "") {
                            $count = User::where("email",$post["email"])->count();
                            $isError = $count;
                        }
                        if($isError == 0) {
                            $user = User::create([
                                'name' => $request->name,
                                'gender' => $request->gender,
                                'dob' => $request->dob,
                                'phone' => $request->phone,
                                'email' => $email,
                                'password' => Hash::make($request->password),
                                'device_type' => $request->device_type,
                                'device_token' => $request->device_token,
                                'created_at' => date("Y-m-d H:i:s")
                            ]);
                            $user_id = $user->id;
                            // $code = rand(1000,9999);
                            $code = 1234;
                            User::where('id',$user_id)->update(["code" => $code]);
                            $token = JWTAuth::fromUser($user);

                            $status = config('constants.RESPONSE_FLAG_SUCCESS');
                            $message = "OTP sent to ".$post["phone"];
                            $responseData = ["token" => $token]; 
                        } else {
                            $status = config('constants.RESPONSE_FLAG_FAIL');
                            $message = 'Email already used.';
                            $responseData = (object) [];
                        }
                    } else {
                        $status = config('constants.RESPONSE_FLAG_FAIL');
                        $message = 'Mobile no. already used.';
                        $responseData = (object) [];
                    }
                    return response()->json([
                        config('constants.RESPONSE_STATUS') => $status,
                        config('constants.RESPONSE_MESSAGE') => $message,
                        config('constants.RESPONSE_DATA') => $responseData
                    ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                } 
            } catch (\Exception $e) {
                return response()->json([
                    config('constants.RESPONSE_STATUS') => config('constants.RESPONSE_FLAG_FAIL'),
                    'message' => $e->getMessage(),
                    config('constants.RESPONSE_DATA') => (object) []
                ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
            }
        }

        // Login user
        public function login(Request $request)
        {
            try {
                $post = $request->all();
                $mandodary_params = array('phone','password','device_token','device_type');
                $validation = ParamValidation($mandodary_params, $post);
                if($validation[config('constants.RESPONSE_STATUS')] == config('constants.RESPONSE_FLAG_FAIL')) {
                    return response()->json($validation, config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                } else {
                    $credentials = $request->only('phone', 'password');
                    if (!$token = JWTAuth::attempt($credentials)) {
                        return response()->json([
                            config('constants.RESPONSE_STATUS') => config('constants.RESPONSE_FLAG_FAIL'),
                            config('constants.RESPONSE_MESSAGE') => 'Invalid credentials',
                            config('constants.RESPONSE_DATA') => (object) []
                        ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                    }
                    $user = auth()->user();
                    $user->device_token = $request->device_token;
                    $user->device_type  = $request->device_type;
                    $user->save();
                    $user->token = $token;
                    $userInfo = check_null($user->toArray());

                    $responseData = $userInfo;  
                    return response()->json([
                        config('constants.RESPONSE_STATUS') => config('constants.RESPONSE_FLAG_SUCCESS'),
                        config('constants.RESPONSE_MESSAGE') => "Profile found.",
                        config('constants.RESPONSE_DATA') => $responseData
                    ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                }
            } catch (\Exception $e) {
                return response()->json([
                    $data[config('constants.RESPONSE_STATUS')] => config('constants.RESPONSE_FLAG_FAIL'),
                    'message' => $e->getMessage(),
                    config('constants.RESPONSE_DATA') => (object) []
                ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
            }
        }

        public function verify_otp(Request $request)
        {
            try {
                $post = $request->all();
                $mandodary_params = array('otp');
                $validation = ParamValidation($mandodary_params, $post);
                if($validation[config('constants.RESPONSE_STATUS')] == config('constants.RESPONSE_FLAG_FAIL')) {
                    return response()->json($validation, config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                } else {
                    $user_id = auth()->user()->id;
                    $customer = User::find($user_id);
                    if($customer) {
                        if($customer["is_phone_verified"] == 0) {
                            if($customer["code"] == $post["otp"]) {
                                User::where('id',$customer["id"])->update(["code" => null,"is_phone_verified" => 1]);

                                $customer["code"] = null;
                                $customer["is_phone_verified"] = 1;
                                $customer = check_null($customer->toArray());
                                
                                $status = config('constants.RESPONSE_FLAG_SUCCESS');
                                $message = "Account verified successfully.";
                                $responseData = $customer; 
                            } else {
                                $status = config('constants.RESPONSE_FLAG_FAIL');
                                $message = "OTP does not match.";
                                $responseData = (object) [];
                            }
                        } else {
                            $customer = check_null($customer->toArray());

                            $status = config('constants.RESPONSE_FLAG_SUCCESS');
                            $message = "Account already verified.";
                            $responseData = $customer; 
                        }
                    } else {
                        $status = config('constants.RESPONSE_FLAG_FAIL');
                        $message = "Mobile no. not found.";
                        $responseData = (object) []; 
                    }
                    return response()->json([
                        config('constants.RESPONSE_STATUS') => $status,
                        config('constants.RESPONSE_MESSAGE') => $message,
                        config('constants.RESPONSE_DATA') => $responseData
                    ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                }
            } catch (\Exception $e) {
                return response()->json([
                    $data[config('constants.RESPONSE_STATUS')] => config('constants.RESPONSE_FLAG_FAIL'),
                    'message' => $e->getMessage()
                ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
            }
        }

        public function resend_otp(Request $request)
        {
            try {
                $post = $request->all();
                $mandodary_params = [];
                $validation = ParamValidation($mandodary_params, $post);
                if($validation[config('constants.RESPONSE_STATUS')] == config('constants.RESPONSE_FLAG_FAIL')) {
                    return response()->json($validation, config('constants.RESPONSE_FLAG_SUCCESS'));
                } else {
                    $user_id = auth()->user()->id;
                    $customer = User::select("id","phone","is_phone_verified")->find($user_id);
                    if ($customer) {
                        if($customer["is_phone_verified"] == 0) {
                            // $code = rand(1000,9999);
                            $code = 4321;
                            User::where('id',$customer["id"])->update(["code" => $code]);

                            $status = config('constants.RESPONSE_FLAG_SUCCESS');
                            $message = "OTP resent to ".$customer["phone"];
                        } else {
                            $status = config('constants.RESPONSE_FLAG_SUCCESS');
                            $message = "Profile already verified.";
                        } 
                    } else {
                        $status = config('constants.RESPONSE_FLAG_FAIL');
                        $message = "Account not found.";
                    }
                    return response()->json([
                        config('constants.RESPONSE_STATUS') => $status,
                        config('constants.RESPONSE_MESSAGE') => $message
                    ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                }
            } catch (\Exception $e) {
                return response()->json([
                    $data[config('constants.RESPONSE_STATUS')] => config('constants.RESPONSE_FLAG_FAIL'),
                    'message' => $e->getMessage()
                ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
            }
        }

        public function forget_password(Request $request)
        {
            try {
                $post = $request->all();
                $mandodary_params = array('phone');
                $validation = ParamValidation($mandodary_params, $post);
                if($validation[config('constants.RESPONSE_STATUS')] == config('constants.RESPONSE_FLAG_FAIL')) {
                    return response()->json($validation, config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                } else {
                    $customer = User::select("id")->where("phone",$post["phone"])->first();
                    if ($customer) {
                        // $code = rand(1000,9999);
                        $code = 1234;
                        User::where('id',$customer["id"])->update(["code" => $code]);

                        $status = config('constants.RESPONSE_FLAG_SUCCESS');
                        $message = "OTP sent to ".$post["phone"]; 
                    } else {
                        $status = config('constants.RESPONSE_FLAG_FAIL');
                        $message = "Mobile no. not found.";
                    }
                    return response()->json([
                        config('constants.RESPONSE_STATUS') => $status,
                        config('constants.RESPONSE_MESSAGE') => $message
                    ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                }
            } catch (\Exception $e) {
                return response()->json([
                    $data[config('constants.RESPONSE_STATUS')] => config('constants.RESPONSE_FLAG_FAIL'),
                    'message' => $e->getMessage()
                ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
            }
        }

        public function reset_password(Request $request)
        {
            try {
                $post = $request->all();
                $mandodary_params = array('phone','otp','new_password','confirm_password');
                $validation = ParamValidation($mandodary_params, $post);
                if($validation[config('constants.RESPONSE_STATUS')] == config('constants.RESPONSE_FLAG_FAIL')) {
                    return response()->json($validation, config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                } else {
                    $customer = User::where("phone",$post["phone"])->first();
                    if ($customer) {
                        if($customer["code"] == $post["otp"]) {
                            if($post["new_password"] == $post["confirm_password"]) {
                                $row = User::find($customer["id"]);
                                $row->password = $post["new_password"];
                                $row->code = null;
                                $row->save();

                                $status = config('constants.RESPONSE_FLAG_SUCCESS');
                                $message = "Password reset successfully."; 
                            } else {
                                $status = config('constants.RESPONSE_FLAG_FAIL');
                                $message = "Password & confirm password must match.";
                            }
                        } else {
                            $status = config('constants.RESPONSE_FLAG_FAIL');
                            $message = "OTP does not match.";
                        }
                    } else {
                        $status = config('constants.RESPONSE_FLAG_FAIL');
                        $message = "Mobile no. not found."; 
                    }
                    return response()->json([
                        config('constants.RESPONSE_STATUS') => $status,
                        config('constants.RESPONSE_MESSAGE') => $message
                    ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                }
            } catch (\Exception $e) {
                return response()->json([
                    $data[config('constants.RESPONSE_STATUS')] => config('constants.RESPONSE_FLAG_FAIL'),
                    'message' => $e->getMessage()
                ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
            }
        }

        // Get current user
        public function my_profile()
        {
            try {
                $user = User::find(auth()->user()->id);
                $responseData = check_null($user->toArray());

                return response()->json([
                    config('constants.RESPONSE_STATUS') => config('constants.RESPONSE_FLAG_SUCCESS'),
                    config('constants.RESPONSE_MESSAGE') => "Profile found successfully.",
                    config('constants.RESPONSE_DATA') => $responseData
                ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                return response()->json(auth()->user());
            } catch (\Exception $e) {
                return response()->json([
                    $data[config('constants.RESPONSE_STATUS')] => config('constants.RESPONSE_FLAG_FAIL'),
                    'message' => $e->getMessage()
                ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
            }
        }

        public function edit_profile(Request $request)
        {
            try {
                $post = $request->all();
                $mandodary_params = array('name','phone','gender','dob');
                $validation = ParamValidation($mandodary_params, $post);
                if($validation[config('constants.RESPONSE_STATUS')] == config('constants.RESPONSE_FLAG_FAIL')) {
                    return response()->json($validation, config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                } else {
                    $user_id = auth()->user()->id;
                    $userdata = User::select("email")->where("phone",$post["phone"])->where("id","!=",$user_id)->first();
                    if(!$userdata) {
                        $user = User::find($user_id);
                        $user->name = $request->name;
                        $user->gender = $request->gender;
                        $user->dob = $request->dob;
                        $user->phone = $request->phone;
                        $user->updated_at = date("Y-m-d H:i:s");
                        if($request->email != "") {
                            $user->email = $request->email != "" ? $request->email : "";
                        }
                        $user->save();

                        $status = config('constants.RESPONSE_FLAG_SUCCESS');
                        $message = "Profile updated successfully.";
                        
                        $user = User::find($user_id);
                        $userInfo = check_null($user->toArray());
                        $responseData = $userInfo; 
                    } else {
                        $status = config('constants.RESPONSE_FLAG_FAIL');
                        $message = 'Mobile no. already used.';
                        $responseData = (object) [];
                    }
                    return response()->json([
                        config('constants.RESPONSE_STATUS') => $status,
                        config('constants.RESPONSE_MESSAGE') => $message,
                        config('constants.RESPONSE_DATA') => $responseData
                    ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                } 
            } catch (\Exception $e) {
                return response()->json([
                    config('constants.RESPONSE_STATUS') => config('constants.RESPONSE_FLAG_FAIL'),
                    'message' => $e->getMessage(),
                    config('constants.RESPONSE_DATA') => (object) []
                ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
            }
        }

        public function delete_profile(Request $request)
        {
            try {
                $post = $request->all();
                $mandodary_params = array('reason');
                $validation = ParamValidation($mandodary_params, $post);
                if($validation[config('constants.RESPONSE_STATUS')] == config('constants.RESPONSE_FLAG_FAIL')) {
                    return response()->json($validation, config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                } else {
                    $user_id = auth()->user()->id;
                    $isDeleted = DeletedAccount::where("user_id",$user_id)->count();
                    if($isDeleted == 0) {
                        $user = User::find($user_id);
                        if($user->delete()) {
                            $deletedAccount = new DeletedAccount;
                            $deletedAccount->user_id = $user_id;
                            $deletedAccount->reason = $request->reason;
                            $deletedAccount->deleted_at = date("Y-m-d H:i:s");
                            $deletedAccount->save();

                            $status = config('constants.RESPONSE_FLAG_SUCCESS');
                            $message = "Profile deleted successfully.";
                        }
                    } else {
                        $status = config('constants.RESPONSE_FLAG_FAIL');
                        $message = 'Profile already deleted.';
                    }
                    return response()->json([
                        config('constants.RESPONSE_STATUS') => $status,
                        config('constants.RESPONSE_MESSAGE') => $message
                    ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                } 
            } catch (\Exception $e) {
                return response()->json([
                    config('constants.RESPONSE_STATUS') => config('constants.RESPONSE_FLAG_FAIL'),
                    'message' => $e->getMessage(),
                    config('constants.RESPONSE_DATA') => (object) []
                ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
            }
        }

        public function change_password(Request $request)
        {
            try {
                $post = $request->all();
                $mandodary_params = array('old_password','new_password','confirm_password');
                $validation = ParamValidation($mandodary_params, $post);
                if($validation[config('constants.RESPONSE_STATUS')] == config('constants.RESPONSE_FLAG_FAIL')) {
                    return response()->json($validation, config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                } else {
                    $user_id = auth()->user()->id;
                    $user = User::find($user_id);
                    if (Hash::check($request->old_password, $user->password)) {
                        if ($request->new_password == $request->confirm_password) {
                            $user->password = Hash::make($request->new_password);
                            $user->save();

                            $status = config('constants.RESPONSE_FLAG_FAIL');
                            $message = 'Password changed successfully.';
                        } else {
                            $status = config('constants.RESPONSE_FLAG_FAIL');
                            $message = 'New password and confirm password must match.';
                        }
                    } else {
                        $status = config('constants.RESPONSE_FLAG_FAIL');
                        $message = 'Old Password is incorrect';
                    }
                    return response()->json([
                        config('constants.RESPONSE_STATUS') => $status,
                        config('constants.RESPONSE_MESSAGE') => $message
                    ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                } 
            } catch (\Exception $e) {
                return response()->json([
                    config('constants.RESPONSE_STATUS') => config('constants.RESPONSE_FLAG_FAIL'),
                    'message' => $e->getMessage(),
                    config('constants.RESPONSE_DATA') => (object) []
                ], config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
            }
        }

        public function logout()
        {
            auth()->logout();
            return response()->json(['message' => 'Successfully logged out']);
        }
    }
