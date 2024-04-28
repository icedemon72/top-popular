<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class ModeratorController extends Controller // implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    // public static function middleware(): array
    // {
    //     return [
    //         new Middleware(['role:admin'], only: ['index'])
    //     ];
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where(['role' => 'moderator'])->get();

        return view('admin.mods.index', [
            'users' => $users
        ]);
    }
}
