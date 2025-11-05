<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Hash;
    use App\Models\Tagline;
    use App\Models\User;
    use Auth;

    class HomeController extends Controller
    {
        public function index()
        {
            $taglines = Tagline::select("title","description")->where("is_active",1)->get();
            return view('landing',compact('taglines'));
        }

        public function register()
        {
            $taglines = Tagline::select("title","description")->where("is_active",1)->get();
            return view('register_step_1',compact('taglines'));
        }

        public function register_as_owner()
        {
            $taglines = Tagline::select("title","description")->where("is_active",1)->get();
            $role = 'V';
            return view('register_as_owner',compact('taglines','role'));
        }

        public function signup(Request $request)
        {
            try {
                $post = $request->all();

                $isPhoneExist = User::where("phone",$post["phone"])->count();
                if($isPhoneExist == 0) {
                    $row = new User;
                    $row->name = $post["name"];
                    $row->email = $post["email"] ? $post["email"] : '';
                    $row->gender = $post["gender"];
                    $row->dob = $post["dob"];
                    $row->phone = $post["phone"];
                    $row->password = Hash::make($post["password"]);
                    $row->role = $post["role"];
                    $row->created_at = date("Y-m-d H:i:s");
                    $row->save();

                    $otp = generate_otp();
                    User::where('id', $row->id)->update(['otp' => $otp]);

                    return response()->json([
                        'success' => true,
                        'message' => "OTP sent to ".$post["phone"],
                        'url' => route('common.verify-otp')
                    ],200);
                } else {
                    return response()->json(['success' => false,'message' => "Mobile no. is already used."], 200);
                }
            } catch (\Exception $e) {
                return response()->json(['success' => false,'message' => $e->getMessage()], 200);
            }
        }

        public function verify_otp()
        {
            return view('verify_otp');
        }
    }
