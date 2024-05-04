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
        $messages = Message::with('user')->orderByDesc('created_at')->get();
        $status = DB::table('messages')
            ->select(DB::raw('status, count(*) as count'))
            ->groupBy('status')
            ->orderBy('count', 'desc')
            ->get();
        dd($status);
        return view('admin.messages.index', [
            'messages' => $messages,
            'status' => $status
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
        $message = Message::where('id', $id)->with('user')->firstOrFail();

        return view('admin.messages.show', [
            'message' => $message
        ]);
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

    /**
     * Sets message's status.
     */
    public function updateStatus(Request $request, string $message) 
    {
        $request->validate([
            'status' => 'required'
        ]);

        $messageObj = Message::where('id', $message)
            ->update([
                'status' => $request->status
            ]); 

        return redirect(route('message.show', $message))->with('success', true);
    }
}
