<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['role:moderator,admin'], only: ['index'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = DB::table('messages')->get();
        
        return view('admin.messages.index', [
            'messages' => $messages
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
        $request->only(['title', 'body', 'category']);
        
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'category' => 'required|string'
        ]);

        $allowedCategories = [
            'Issue', 'Suggestion', 'Bug', 'Request', 'Other'
        ];

        if(!in_array($request->category, $allowedCategories)) {
            $request['category'] = 'Other';
        }

        Message::create([
            'title' => $request->title,
            'body' => $request->body,
            'category' => $request->category,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('contact')->with('success', 'Message successfully sent');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
