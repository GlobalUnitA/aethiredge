<?php

namespace App\Http\Controllers\Package;

use App\Models\Policy;
use App\Models\AthDevice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    protected $policy;

    public function __construct()
    {
        $this->policy = Policy::where('type', 'device_policy')->first();    
    }
    
    public function index()
    {
    
        $data = [
            'device' => $this->policy->content['price'],
            'waiting' => DB::table('ath_device')
                ->where('user_id', auth()->id())
                ->where('status', 'o')
                ->count()
        ];

        return view('package.device', $data);
    }

    public function apply(Request $request)
    {
        $data = [
            'address' => $this->policy->content['address'],
            'apply' => $request->validate([
                'ea' => 'required|numeric',
                'usdt' => 'required|integer',
            ])
        ];

        return view('package.device-apply', $data);
    }

    public function store(Request $request)
    {   
    
        if ($request->hasFile('file')) {
            
            $validated = $request->validate([
                'ea' => 'required|numeric',
                'usdt' => 'required|integer',
                'file' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'txid' => 'required|string',
            ]);

            $apply['ea'] = $validated['ea'];
            $apply['usdt'] = $validated['usdt'];

            $file = $request->file('file');
            
            if ($file->isValid()) {
                
                $file_name = '_' . time() . '_' . auth()->id() . '_' . $file->getClientOriginalName();

                $file_path = $file->storeAs('public/uploads/device', $file_name);
                $file_url[] = asset('storage/uploads/device/' . $file_name);

                $device = $this->create($validated, json_encode($file_url));
               
                return response()->json([
                    'status' => 'success',
                    'message' => '작업이 성공적으로 완료되었습니다.',
                    'url' => route('home'),
                ]);

            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => '잘못된 이미지입니다.',
                ]);

            }
        }
       
        return response()->json([
            'status' => 'error',
            'message' => '이미지를 첨부해주세요.',
        ]);
        
    }

    public function list()
    {
        $list = AthDevice::where('user_id', auth()->id())->paginate(10);

        return view('package.device-list', compact('list'));
    }

    protected function create(array $data, $file_urls)
    {
        DB::beginTransaction();

        try{

            $device = AthDevice::create([
                'user_id' => auth()->id(),
                'ea' => $data['ea'],
                'usdt' => $data['usdt'],
                'txid' => $data['txid'],
                'image_urls' => $file_urls,
            ]);
    
            DB::commit();
            return $device;

        } catch (Exception $e) {
          
            DB::rollBack();
            throw new Exception('Something went wrong: ' . $e->getMessage());
        }        
    }
}
