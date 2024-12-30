<?php

namespace App\Http\Controllers\Package;

use App\Models\Policy;
use App\Models\AthStaking;
use App\Models\AthStakingTest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StakingController extends Controller
{
    protected $policy;

    public function __construct()
    {
        $this->policy = Policy::where('type', 'staking_policy')->first();
    }
    
    public function index()
    {
       
        $data = [
            'staking' => $this->policy->content['price'],
            'waiting' => DB::table('ath_staking')
                ->where('user_id', auth()->id())
                ->where('status', 'o')
                ->count()
        ];

        return view('package.staking', $data);
    }

    public function apply(Request $request)
    {
        $data = [
            'address' => $this->policy->content['address'],
            'apply' => $request->validate([
                'ea' => 'required|integer',
                'bundle' => 'required|integer',
                'ath' => 'required|integer',
            ])
        ];

        return view('package.staking-apply', $data);
    }

    public function store(Request $request)
    {   
    
        if ($request->hasFile('file')) {
            
            $validated = $request->validate([
                'ea' => 'required|integer',
                'bundle' => 'required|integer',
                'ath' => 'required|integer',
                'file' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'txid' => 'required|string',
            ]);

            $apply['ea'] = $validated['ea'];
            $apply['bundle'] = $validated['bundle'];
            $apply['ath'] = $validated['ath'];

            $file = $request->file('file');
            
            if ($file->isValid()) {
                
                $file_name = '_' . time() . '_' . auth()->id() . '_' . $file->getClientOriginalName();

                $file_path = $file->storeAs('public/uploads/staking', $file_name);
                $file_url[] = asset('storage/uploads/staking/' . $file_name);

                $staking = $this->create($validated, json_encode($file_url));
               
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

    public function test()
    {
        $list = AthStaking::where('user_id', auth()->id())->where('status', 'p')->paginate(10);

        
        foreach ($list as $key => $val) {
            $val->bonus = AthStakingTest::where('user_id', auth()->id())->where('aff_user_id', '==', '0')->where('staking_id', $val->id)->get();
            $val->allowance = AthStakingTest::where('user_id', auth()->id())->where('aff_user_id', '!=', '0')->where('staking_id', $val->id)->get();
        }

        return view('package.staking-test', compact('list'));
    }

    protected function create(array $data, $file_urls)
    {
        DB::beginTransaction();

        try{

            $staking = AthStaking::create([
                'user_id' => auth()->id(),
                'ea' => $data['ea'],
                'bundle' => $data['bundle'],
                'ath' => $data['ath'],
                'txid' => $data['txid'],
                'image_urls' => $file_urls,
            ]);
    
            DB::commit();
            return $staking;

        } catch (Exception $e) {
          
            DB::rollBack();
            throw new Exception('Something went wrong: ' . $e->getMessage());
        }        
    }
}
