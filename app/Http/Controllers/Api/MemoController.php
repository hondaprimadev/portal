<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MemoController extends Controller
{

	public function __construct()
	{
		$this->middleware('memo.inbox.valid')->only('InboxIndex','InboxCount');
	}
	public function InboxIndex($id)
	{
		// $memo = Memo::where('to_memo', $id)
		// 		->where('status_memo', 'not like', 'REVISE%')
		// 		->get();
        $memo = Memo::with('userFrom.pictures')
                ->where('to_memo', $id)
                ->where('status_memo', 'not like', 'REVISE%')
                ->limit(5)
                ->get();

        
		if (!$memo) {
            return Response::json([
                'status'=> '404',
                'message' => 'cannot fetch this data',
            ],404);
        }else{
            return Response::json([
                'status'=> '200',
                'message' => 'Memo Inbox fetch Succesfully',
                'data' => $memo
            ],200);
        }
	}
    public function InboxCount($id)
    {
    	$memo = Memo::where('to_memo', $id)
    			->where('status_memo', 'not like', 'REVISE%')
    			->count();

    	if (!$memo) {
            return Response::json([
                'status'=> '404',
                'message' => 'cannot fetch this data',
            ],404);
        }else{
            return Response::json([
                'status'=> '200',
                'message' => 'Memo Inbox fetch Succesfully',
                'count' => $memo
            ],200);
        }
    }
}
