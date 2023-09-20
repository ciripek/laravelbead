<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Label;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("item.index", [
            "items" => Item::orderByDesc("obtained")->simplePaginate(9),
            "labels" => Label::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (!Auth::user()?->is_admin){
            abort(401);
        }

        return view("item.create", [
            "labels" => Label::all()
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

        if (!Auth::user()?->is_admin){
            abort(401);
        }

        $re = $request->validate([
           "name" => "required|string",
            "description" => "required|string|max:1000",
            "obtained" => "required|date",
            "image" => "nullable|image|mimes:jpg,png,jpeg,gif,svg",
            "labels.*" => "exists:items,id"
        ]);


        $labels = $re["labels"];
        unset($re["labels"]);
        if ($request->hasFile("image")){
            $path = $request->file("image")->store("public/images");
            $re["image"] = $path;
            $re["image_name"] = $request->file('image')->getClientOriginalName();
        } else {
            $re["image_name"] = null;
        }
        $item = Item::create($re);
        $item->labels()->sync(array_map('intval', $labels ));
        $item->save();


        return redirect()->route("items.index")->with("success", "Új tárgyat hoztak létre");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        $labels = $item->labels;
        $comments = $item->comments->sortByDesc("created_at");


        return view("item.show", [
            "item" => $item,
            "labels" => $labels,
            "comments" => $comments
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        if (!Auth::user()?->is_admin){
            abort(401);
        }

        return view("item.edit", [
            "item" => $item,
            "labels" => Label::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        if (!Auth::user()?->is_admin){
            abort(401);
        }


        $re = $request->validate([
            "name" => "required|string",
            "description" => "required|string|max:1000",
            "obtained" => "required|date",
            "image" => "nullable|image|mimes:jpg,png,jpeg,gif,svg",
            "labels.*" => "exists:items,id"
        ]);


        if (isset($re["labels"])){
            $labels = $re["labels"];
            unset($re["labels"]);
        } else {
            $labels = [];
        }


        if ($request->hasFile("image")){
            $path = $request->file("image")->store("public/images");
            $re["image"] = $path;
            $re["image_name"] = $request->file('image')->getClientOriginalName();
        }

        $item->update($re);
        $item->labels()->sync(array_map('intval', $labels ));
        $item->save();

        return redirect()->route("items.show", $item)->with("success", "Tárgy módósítása sikeres");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        if (!Auth::user()?->is_admin){
            abort(401);
        }

        $item->delete();

        return redirect()->route("items.index")->with("success", "Tárgy törlése sikeres");
    }
}
