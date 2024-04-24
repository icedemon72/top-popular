<?php

namespace App\Http\Controllers;

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
        $users = DB::table('users')
            ->where(['role' => 'moderator'])
            ->get();

        return view('admin.mods.index', [
            'users' => $users
        ]);
    }
}
