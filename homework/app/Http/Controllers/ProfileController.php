<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Profile::with('user')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image'=>'image|mimes:jpg,png,jpg',
            'city'=>'required',
        ]);
        $request->file('image')->store('public/images');
        $name = $request->file('image')->getClientOriginalName();
        $profile = new Profile();
        $profile-> user_id = $request -> user_id;
        $profile->city = $request -> city;
        $profile->image = $request->file('image')->hashName();
        $profile->save();
        //RETURN MESSAGE
        return response()->json('created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Profile::with('user')->findOrFail($id);
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
        $request->validate([
            'image'=>'image|mimes:jpg,png,jpg',
            'city'=>'required',
        ]);
        $request->file('image')->store('public/images');
        $name = $request->file('image')->getClientOriginalName();
        $profile = Profile::findOrFail($id);
        $profile-> user_id = $request -> user_id;
        $profile->city = $request -> city;
        $profile->image = $request->file('image')->hashName();
        $profile->save();
        //RETURN MESSAGE
        return response()->json('Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Profile::destroy($id);
    }
}
