<?php 
    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\Language;
    use App\Models\Plan;
    use App\Models\Category;
    use App\Models\Frame;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Tymon\JWTAuth\Facades\JWTAuth;

    class CommonController extends Controller
    {
        public function languages(Request $request)
        {
            try {
                $post = $request->all();
                $mandodary_params = [];
                $validation = ParamValidation($mandodary_params, $post);
                if($validation[config('constants.RESPONSE_STATUS')] == config('constants.RESPONSE_FLAG_FAIL')) {
                    return response()->json($validation, config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                } else {
                    $responseData = Language::select("id","name")->where("is_active",1)->orderBy("name","asc")->get();
                    return response()->json([
                        config('constants.RESPONSE_STATUS') => config('constants.RESPONSE_FLAG_SUCCESS'),
                        config('constants.RESPONSE_MESSAGE') => "Total ".count($responseData)." languages found.",
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

        public function plans(Request $request)
        {
            try {
                $post = $request->all();
                $mandodary_params = [];
                $validation = ParamValidation($mandodary_params, $post);
                if($validation[config('constants.RESPONSE_STATUS')] == config('constants.RESPONSE_FLAG_FAIL')) {
                    return response()->json($validation, config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                } else {
                    $responseData = Plan::select("id","name","duration","amount","discount_amount")->where("is_active",1)->orderBy("name","asc")->get();
                    return response()->json([
                        config('constants.RESPONSE_STATUS') => config('constants.RESPONSE_FLAG_SUCCESS'),
                        config('constants.RESPONSE_MESSAGE') => "Total ".count($responseData)." plans found.",
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

        public function frames(Request $request)
        {
            try {
                $post = $request->all();
                $mandodary_params = [];
                $validation = ParamValidation($mandodary_params, $post);
                if($validation[config('constants.RESPONSE_STATUS')] == config('constants.RESPONSE_FLAG_FAIL')) {
                    return response()->json($validation, config('constants.RESPONSE_FLAG_SUCCESS_CODE'));
                } else {
                    $responseData = Category::select("id","name")->where("is_active",1)->orderBy("name","asc")->get();
                    if($responseData) {
                        foreach($responseData as $key => $val) {
                            $frames = Frame::select("id","avatar","point")->where("category_id",$val["id"])->where("is_active",1)->orderBy("point","asc")->get();
                            $responseData[$key]["items"] = $frames;
                        }
                    }
                    return response()->json([
                        config('constants.RESPONSE_STATUS') => config('constants.RESPONSE_FLAG_SUCCESS'),
                        config('constants.RESPONSE_MESSAGE') => "",
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
    }