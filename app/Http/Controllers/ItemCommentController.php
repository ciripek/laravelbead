<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function index(Item $item)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function create(Item $item)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Item $item)
    {

        if (!Auth::user()?->is_admin && !Auth::hasUser()){
            abort(401);
        }

        $re = $request->validate([
            "text" => "required|string"
        ]);

        Comment::factory()
            ->for($item)
            ->for(Auth::user())
            ->create($re);

        return redirect()->route("items.show", $item)->with("success", "Sikeres hozzászólás");;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item, Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item, Comment $comment)
    {
        $user_id = $comment->user_id;
        if (!Auth::user()?->is_admin && Auth::id() != $user_id){
            abort(401);
        }

        return view("item.comment.edit", [
            "item" => $item,
            "comment" => $comment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item, Comment $comment)
    {
        $user_id = $comment->user_id;
        if (!Auth::user()?->is_admin && Auth::id() != $user_id){
            abort(401);
        }

        $re = $request->validate([
            "text" => "required|string"
        ]);

        $comment->update($re);

        return redirect()->route("items.show", $item)->with("success", "Hozzászolás módósítása");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item, Comment $comment)
    {
        $user_id = $comment->user_id;
        if (!Auth::user()?->is_admin && Auth::id() != $user_id){
            abort(401);
        }

        $comment->delete();

        return redirect()->route("items.show", $item)->with("success", "A hozzászolást törölték");
    }
}
