<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }
  
    public function collection()
    {
        
        $query = DB::table('users')
            ->leftJoin('ath_user', 'users.id', '=', 'ath_user.user_id')
            ->select(
                'users.id',
                'users.account',
                'users.name',
                'ath_user.phone',
                'ath_user.meta_uid',
                'users.created_at'
            );

      
        if (!empty($this->filters['keyword']) && $this->filters['category'] == 'mid') {
            $query->where('users.id', $this->filters['keyword']);
        }

        if (!empty($this->filters['keyword']) && $this->filters['category'] == 'account') {
            $query->where('users.account', $this->filters['keyword']);
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('users.created_at', [$this->filters['start_date'], $this->filters['end_date']]);
        }

        return $query->get();
    }

  
    public function headings(): array
    {
        return ['MID', '아이디', '회원명', '연락처', '메타웨이브 UID', '가입일자'];
    }
}