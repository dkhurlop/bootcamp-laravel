<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('tweets.index',[
            'tweets' => Tweet::with('user')->latest()->get()
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $validated = $request->validate([
        'message' => ['required', 'min:3', 'max:255'],
    ]);

    auth()->user()->tweets()->create($validated);

        return to_route('tweets.index')->with('success', __('Tweet Created Successfully'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        if (auth()->user()->isNot($tweet->user)) {
           abort(403);
        }
        
        return view('tweets.edit',[
        'tweet'=> $tweet,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweet $tweet)
    {
        $validated = $request->validate([
            'message' => ['required', 'min:3', 'max:255'],
        ]);
    
        $tweet->update($validated);
        return to_route('tweets.index')
        ->with('success', __('Tweet update Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {

        $tweet->delete();
        return to_route('tweets.index')->with('success', __('Tweet Deleted Successfully'));
    }
}
