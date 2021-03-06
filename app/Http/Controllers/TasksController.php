<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }
        // タスク一覧ビューでそれらを表示
        return view('tasks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tasks = new Task;
        // メッセージ作成ビューを表示
        return view('tasks.create', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //バリデーション
        $request->validate([
            'status' => 'required|max:20', 
            'content' => 'required|max:255',
        ]);
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // idの値でメッセージを検索して取得
        $tasks = Task::findOrFail($id);
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、閲覧を可能にする
        if (\Auth::id() === $tasks->user_id) {
            return view('tasks.show', [
            'tasks' => $tasks,
        ]);
        } else {
            // トップページへリダイレクトさせる
            return redirect('/');
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // idの値でタスクを検索して取得
        $tasks = Task::findOrFail($id);
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、表示する
        if (\Auth::id() === $tasks->user_id) {
            return view('tasks.edit', [
            'tasks' => $tasks,
        ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        //バリデーション
        $request->validate([
            'status' => 'required|max:20', //追加
            'content' => 'required|max:255',
        ]);
        // idの値でメッセージを検索して取得
        $tasks = Task::findOrFail($id);
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を更新可能にする
        if (\Auth::id() === $tasks->user_id) { //$tasksをtaskから変更済み
            $tasks->status = $request->status; //追加
            $tasks->content = $request->content;
            $tasks->save();
        }
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // idの値でタスクを検索して取得
        $tasks = Task::findOrFail($id);
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $tasks->user_id) { //$tasksをtaskから変更済み
            $tasks->delete(); //$tasksをtaskから変更済み
        }
        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
