<?php 

namespace App\Models;

use App\Models\AthUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Chart
{
    public $data = [];
    public $mode;
    public $is_admin = 0;

    public function getChartData($user_id)
    {

        $user = AthUser::where('ath_user.user_id', $user_id)
            ->join('users', 'ath_user.user_id', '=', 'users.id')
            ->select('ath_user.part_usdt', 'ath_user.part_ath', 'users.id', 'users.name', 'users.account', 'users.created_at')
            ->first();
        
       
        $this->data[] = $this->writeNodeData($user);
    
        $this->addChildrenData($user);

    }

    protected function addChildrenData($parent_user)
    {
       
        $children = AthUser::where('ath_user.parent_id', $parent_user->id)
            ->join('users', 'ath_user.user_id', '=', 'users.id')
            ->select('ath_user.part_usdt', 'ath_user.part_ath', 'users.id', 'users.name', 'users.account', 'users.created_at')
            ->get(); 

        if ($children->isEmpty()) {
            return;
        }

        foreach ($children as $child) {

            $this->data[] = $this->writeNodeData($child, $parent_user->id);

            if($this->mode == 'aff'){
                $this->addChildrenData($child);    
            } 
        }
    }

    protected function writeNodeData($user, $parent = null)
    {
        if($this->is_admin){
            $node = [
                'id' => strval($user->id),  
                'parent' => strval($parent),
                'info' => "이름 : {$user->name} <br> <i>{$user->account}</i> <br> USDT: ".number_format($user->part_usdt)." <br> 스테이킹: ".number_format($user->part_staking)." <br> 가입일자: ".$user->created_at->format('Y-m-d'),
            ];
        } else {
            $node = [
                'id' => strval($user->id),  
                'parent' => strval($parent),
                'info' => "<i>{$user->account}</i> <br> USDT: ".number_format($user->part_usdt)." <br> 스테이킹: ".number_format($user->part_staking)." <br> 가입일자: ".$user->created_at->format('Y-m-d'),
            ];
        }
        
        return $node;
    }

}