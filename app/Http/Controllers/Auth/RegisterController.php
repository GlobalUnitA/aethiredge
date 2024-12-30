<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AthUser;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;

class RegisterController extends Controller
{
    
  
    /**
    * Display the form for creating a new user.
    *
    * @method GET
    * @return \Illuminate\View\View
    */
    public function index($mid=null)
    {   
        return view('auth.register', compact('mid'));
    }

    /**
    * Register.
    *
    * @method POST
    * @return \Illuminate\Http\JsonResponse
    */
    public function register(Request $request)
    {
        $validated = $this->validator($request->all())->validate();

        try {
            $user = $this->create($validated);

            Auth::login($user);

            return response()->json([
                'status' => 'success',
                'message' => '회원가입이 완료되었습니다.',
                'url' => route('home'),
            ]);

        } catch (\Exception $e) {
            
            return response()->json([
                'status' => 'error',
                'message' => '회원가입에 실패했습니다. 다시 시도해주세요.',
            ]);
        }
    }

    /**
    * Form validation.
    *
    *
    * @return Illuminate\Support\Facades\Validator
    */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'account' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).+$/', 'confirmed'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'min:9', 'max:12'],
            'metaUid' => ['nullable', 'string'],
            'parentId' => ['required', 'integer'],
        ]);
    }

    /**
    * Creating a new user.
    *
    *
    * @return App\Models\User
    */
    protected function create(array $data)
    {
        DB::beginTransaction();

        try{

            $parent = DB::table('users')
            ->join('ath_user', 'users.id', '=', 'ath_user.user_id')
            ->select('users.id', 'ath_user.level')
            ->where('users.id', '=', $data['parentId'])
            ->first();

            if (!$parent) {
                throw new Exception('존재하지 않는 추천인입니다.');
            }

            $user = User::create([
                'name' => $data['name'],
                'account' => $data['account'],
                'password' => Hash::make($data['password'])
            ]);
    
            AthUser::create([
                'user_id' => $user->id,
                'parent_id' => $parent->id,
                'level' => $parent->level + 1,
                'email' => $data['email'],
                'phone' => $data['phone'],
                'meta_uid' => $data['metaUid']
            ]);
    
            DB::commit();

            return $user;

        } catch (Exception $e) {
          
            DB::rollBack();
            
            throw new Exception('Something went wrong: ' . $e->getMessage());
        }        
    }
}
