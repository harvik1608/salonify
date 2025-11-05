<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    use App\Models\General_setting;
    use Auth;

    class DashboardController extends Controller
    {
        public function index()
        {
            $response = Http::post(url('/api/check-number'), [
                'phone' => 9714191947
            ]);

            print_r ($response->json());
            exit;
            return view('admin.dashboard');
        }

        public function general_settings()
        {
            $general_settings = General_setting::all();
            $data = array();
            foreach($general_settings as $general_setting) {
                $data[$general_setting->setting_key] = $general_setting->setting_val;
            }
            return view('admin.general_settings',$data);
        }

        public function submit_general_settings(Request $request)
        {
            try {
                $post = $request->all();
                unset($post['_token']);
                
                $data = array();
                foreach($post as $key => $val) {
                    $data[] = ['setting_key' => $key,'setting_val' => $val];
                }
                
                General_setting::truncate();
                General_setting::insert($data);
                return response()->json(['success' => true,'message' => "General Settings updated successfully."], 200);
            } catch (\Exception $e) {
                return response()->json(['success' => false,'message' => $e->getMessage()], 200);
            }
        }
    }
