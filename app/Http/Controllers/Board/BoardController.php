<?php

namespace App\Http\Controllers\Board;

use App\Models\AthBoard;
use App\Models\AthPost;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BoardController extends Controller
{  
    protected $board;

    public function __construct()
    {
       
    }
    
    public function list(Request $request)
    {
        $board = AthBoard::where('board_code', $request->code)->first();

        $list = AthPost::join('ath_board', 'ath_post.board_code', '=', 'ath_board.board_code')
        ->join('users', 'users.id', '=', 'ath_post.user_id')
        ->select('ath_post.*', 'users.account')
        ->when($request->code == 'qna', function ($query) {
            $query->where('ath_post.user_id', auth()->id());
        })
        ->where('ath_board.board_code', $board->board_code)
        ->where('ath_post.comment_id', 0)
        ->orderBy('ath_post.created_at', 'desc')
        ->paginate(10); 

        $list->appends(request()->all());

        $data = [
            'board' => $board,
            'list' => $list,
        ];

        return view('board.list', $data);

    }

    public function view(Request $request)
    {

        $mode = $request->mode;
        $board = AthBoard::where('board_code', $request->code)->first();
        $view = AthPost::find($request->id);
        $comment = AthPost::where('comment_id', $request->id)->first();

        if($mode == 'view') {
            $user = User::find($view->user_id);

            $data = [
                'mode' => $mode,
                'board' => $board,
                'view' => $view,
                'comment' => $comment,
                'user' => $user,
            ];
       
            return view('board.view', $data);
        } else {

            $data = [
                'mode' => $mode,
                'board' => $board,
                'view' => $view,
            ];

            return view('board.write', $data);
        }
    }

    public function write(Request $request)
    {
       
        DB::beginTransaction();
    
        try{

            $post = AthPost::create([
                'user_id' => auth()->id(),
                'board_code' => $request->code,
                'subject' => $request->subject,
                'content' => $request->content,
               // 'image_urls' => $file_urls,
            ]);
    
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => '작성되었습니다.',
                'url' => route('board.list', ['code' =>  $request->code]),
            ]);

        } catch (Exception $e) {
          
            DB::rollBack();

            \Log::error('Failed to write post', ['error' => $e->getMessage()]);

            return response()->json([
                'status' => 'error',
                'message' => '예기치 못한 오류가 발생했습니다.',
            ]);
        }        
    }

    /*
    public function modify(Request $request)
    {

        $post = AthPost::find($request->id);

        if ($post) {

            DB::beginTransaction();

            try {

                $post->update([
                    'subject' => $request->subject,
                    'content' => $request->content,
                ]);

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => '수정되었습니다.',
                    'url' => route('board.view', ['code' =>  $request->code, 'mode' => 'view', 'id' => $request->id]),
                ]);

            } catch (\Exception $e) {
                DB::rollBack();

                \Log::error('Failed to update device', ['error' => $e->getMessage()]);

                return response()->json([
                    'status' => 'error',
                    'message' => '예기치 못한 오류가 발생했습니다.',
                ]);
            }
        }
    }
    */

}
