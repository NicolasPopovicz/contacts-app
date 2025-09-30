<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function me(Request $req)
    {
        return response()->json([
            'message' => 'me'
        ], 200);
    }

    public function deleteAccount(Request $req)
    {
        return response()->json([
            'message' => 'deleteAccount'
        ], 200);
    }

    public function logout(Request $req)
    {
        return response()->json([
            'message' => 'logout'
        ], 200);
    }
}
