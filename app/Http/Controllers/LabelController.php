<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        return view("label.create");
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
            "display" => "",
            "color" => "required"
        ]);

        if (!isset($re["display"])){
            $re["display"] = false;
        } else {
            $re["display"] = true;
        }

        Label::factory()->create($re);


        return redirect()->route("items.index")->with("success", "Sikeres cimke létrehozás");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        return view("label.show", [
            "label" => $label,
            "label_items" => $label->items()->simplePaginate(9),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        if (!Auth::user()?->is_admin){
            abort(401);
        }
        return view("label.edit", [
            "label" => $label
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        if (!Auth::user()?->is_admin){
            abort(401);
        }
        $re = $request->validate([
            "name" => "required|string",
            "display" => "",
            "color" => "required"
        ]);

        if (!isset($re["display"])){
            $re["display"] = false;
        } else {
            $re["display"] = true;
        }

        $label->update($re);

        return redirect()->route("labels.show", $label)->with("success", "A cimke sikeresen lett modósítva");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        if (!Auth::user()?->is_admin){
            abort(401);
        }

        $label->delete();

        return redirect()->route("items.index")->with("success", "A cimkét sikeresen törölték");
    }
}
