<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Str;
    use App\Models\Service_group;
    use Auth;

    class ServiceGroupController extends Controller
    {
        public function index()
        {
            return view('admin.service_group.list');
        }

        public function load(Request $request)
        {
            try {
                $draw = intval($request->get('draw', 0));
                $start = intval($request->get('start', 0));
                $length = intval($request->get('length', 10));
                $searchValue = $request->input('search.value', '');

                $query = Service_group::query();
                if (!empty($searchValue)) {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('name', 'like', "%{$searchValue}%");
                    });
                }
                $recordsTotal = Service_group::count();
                $recordsFiltered = $query->count();
                $rows = $query->offset($start)->limit($length)->orderBy('id', 'desc')->get();

                $formattedData = [];
                foreach ($rows as $index => $row) {
                    $avatar = "-";
                    if($row->avatar != "" && file_exists(public_path('uploads/service_group/'.$row->avatar))) {
                        $avatar = '<img src="'.asset('uploads/service_group/'.$row->avatar).'" class="country-flag" />'; 
                    }
                    $actions = '<div class="edit-delete-action">';
                        $actions .= '<a href="' . url('admin/service_groups/'.$row->id.'/edit/') . '" class="me-2 edit-icon p-2 text-success" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>';
                        $actions .= '<a href="javascript:;" onclick="remove_row(\'' . url('admin/service_groups/' . $row->id) . '\')" data-bs-toggle="modal" data-bs-target="#delete-modal" class="p-2" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </a>';
                    $actions .= '</div>';
                    $formattedData[] = [
                        'id' => $start + $index + 1,
                        'avatar' => $avatar,
                        'name' => $row->name,
                        'status' => $row->is_active
                            ? '<span class="badge badge-success badge-xs d-inline-flex align-items-center">Active</span>'
                            : '<span class="badge badge-danger badge-xs d-inline-flex align-items-center">Inactive</span>',
                        'actions' => $actions
                    ];
                }
                return response()->json([
                    'draw' => $draw,
                    'recordsTotal' => $recordsTotal,
                    'recordsFiltered' => $recordsFiltered,
                    'data' => $formattedData,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Server Error: ' . $e->getMessage(),
                ], 500);
            }
        }


        public function create()
        {
            try {
                $service_group = null;
                return view('admin.service_group.add_edit',compact('service_group'));
            } catch (\Exception $e) {
                return response()->json(['success' => false,'message' => $e->getMessage()], 200);
            }
        }

        public function store(Request $request)
        {
            try {
                $post = $request->all();
                $avatar = "";

                if ($request->hasFile('image')) {
                    $image = $request->file('image');

                    // generate random file name
                    $avatar = Str::random(20) . '.' . $image->getClientOriginalExtension();
                    $path = $image->move(public_path('uploads/service_group'), $avatar);
                }

                $row = new Service_group;
                $row->slug = Str::slug($post['name'], '-');
                $row->name = $post['name'];
                $row->avatar = $avatar;
                $row->is_active = $post['is_active'];
                $row->created_by = Auth::user()->id;
                $row->updated_by = 0;
                $row->created_at = date("Y-m-d H:i:s");
                $row->save();

                return response()->json(['success' => true,'message' => "Service Group added successfully."], 200);
            } catch (\Exception $e) {
                return response()->json(['success' => false,'message' => $e->getMessage()], 200);
            }
        }

        public function edit($id)
        {
            try {
                $service_group = Service_group::find($id);
                if(!$service_group) {
                    return redirect()->route("admin.dashboard");
                }
                return view('admin.service_group.add_edit',compact('service_group'));   
            } catch (\Exception $e) {
                return response()->json(['success' => false,'message' => $e->getMessage()], 200);
            }
        }

        public function update(Request $request,$id)
        {
            try {
                $post = $request->all();
                $avatar = $post["old_avatar"];

                if ($request->hasFile('image')) {
                    $image = $request->file('image');

                    // generate random file name
                    $avatar = Str::random(20) . '.' . $image->getClientOriginalExtension();
                    $path = $image->move(public_path('uploads/service_group'), $avatar);

                    // delete old image
                    if($post["old_avatar"] != "" && file_exists(public_path('uploads/service_group/'.$post["old_avatar"]))) {
                        unlink((public_path('uploads/service_group/'.$post["old_avatar"])));
                    }
                }
                $row = Service_group::find($id);
                $row->slug = Str::slug($post['name'], '-');
                $row->name = $post['name'];
                $row->avatar = $avatar;
                $row->is_active = $post['is_active'];
                $row->updated_by = Auth::user()->id;
                $row->updated_at = date("Y-m-d H:i:s");
                $row->save();

                return response()->json(['success' => true,'message' => "Service Group edited successfully."], 200);
            } catch (\Exception $e) {
                return response()->json(['success' => false,'message' => $e->getMessage()], 200);
            }
        }

        public function destroy($id)
        {
            try {
                Service_group::destroy($id);
                return response()->json(['success' => true,'message' => "Service Group removed successfully."], 200);
            } catch (\Exception $e) {
                return response()->json(['success' => false,'message' => $e->getMessage()], 200);
            }
        }
    }