<?php

namespace App\Http\Controllers\Admin\Board;

use App\Models\AthBoard;
use App\Models\AthPost;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BoardController extends Controller
{

    public function __construct()
    {
       
    }
    
    public function list(Request $request)
    {
        $board = AthBoard::where('board_code', $request->code)->first();

        $list = AthPost::join('ath_board', 'ath_post.board_code', '=', 'ath_board.board_code')
        ->join('users', 'users.id', '=', 'ath_post.user_id')
        ->select('ath_post.*', 'users.account')
        ->when(request('category') != '', function ($query) {
            if(request('category') == 'mid'){
                $query->where('users.id', request('keyword'));
            } else {
                $query->where('users.account', request('keyword'));
            }
        })
        ->when(request('start_date'), function ($query) {
            $start_date = Carbon::parse(request('start_date'))->startOfDay();
            $query->where('ath_post.created_at', '>=', $start_date);
        })
        ->when(request('end_date'), function ($query) {
            $end_date = Carbon::parse(request('end_date'))->endOfDay();
            $query->where('ath_post.created_at', '<=', $end_date);
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

        return view('admin.board.list', $data);

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
                'user' => $user,
                'comment' => $comment,
            ];
       
            return view('admin.board.view', $data);
        } else if($mode == 'comment') {
            $user = User::find($view->user_id);

            $data = [
                'mode' => $mode,
                'board' => $board,
                'view' => $view,
                'user' => $user,
                'comment' => $comment,
            ];

            return view('admin.board.comment', $data);

        } else {

            $data = [
                'mode' => $mode,
                'board' => $board,
                'view' => $view,
            ];

            return view('admin.board.write', $data);
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
                'url' => route('admin.board.list', ['code' =>  $request->code]),
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

    public function comment(Request $request)
    {
        
        $post = AthPost::find($request->id);
        $comment = AthPost::where('comment_id', $request->id)->first();
       
        if ($post) {

            DB::beginTransaction();

            try {
                
                if($comment) {
                    $comment->update([
                        'content' => $request->content,
                    ]);
                } else {
                    AthPost::create([
                        'user_id' => auth()->id(),
                        'board_code' => $request->code,
                        'comment_id' => $post->id,
                        'subject' => $request->subject,
                        'content' => $request->content,
                    // 'image_urls' => $file_urls,
                    ]);
                }
                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => '답글이 작성성되었습니다.',
                    'url' => route('admin.board.list', ['code' =>  $request->code]),
                ]);

            } catch (\Exception $e) {
                DB::rollBack();

                \Log::error('Failed to create comment', ['error' => $e->getMessage()]);

                return response()->json([
                    'status' => 'error',
                    'message' => '예기치 못한 오류가 발생했습니다.',
                ]);
            }
        }
    }

    public function modify(Request $request)
    {

        $post = AthPost::where('id', $request->id)->first();

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
                    'url' => route('admin.board.list', ['code' =>  $request->code]),
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

    public function delete(Request $request)
    {
        $postIds = $request->input('check', []);

         if (count($postIds) > 0) {
            try {
                DB::transaction(function () use ($postIds) {
                    // 선택된 게시글 삭제
                    AthPost::whereIn('id', $postIds)->delete();
                });

                return response()->json([
                    'status' => 'success',
                    'message' => '삭제되었습니다.',
                    'url' => route('admin.board.list', ['code' => $request->code]),
                ]);
            } catch (\Exception $e) {
                Log::error('게시글 삭제 실패: ' . $e->getMessage());

                return response()->json([
                    'status' => 'error',
                    'message' => '삭제 중 오류가 발생했습니다.',
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => '선택된 게시글이 없습니다.',
            ]);
        }
    }
}