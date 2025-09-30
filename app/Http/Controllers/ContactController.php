<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $req)
    {
        return response()->json([
            'message' => 'list'
        ], 200);
    }

    public function store(Request $req)
    {
        return response()->json([
            'message' => 'create'
        ], 201);
    }

    public function show(Request $req)
    {
        return response()->json([
            'message' => 'show'
        ], 200);
    }

    public function update(Request $req)
    {
        return response()->json([
            'message' => 'update'
        ], 201);
    }

    public function destroy(Request $req)
    {
        return response()->json([
            'message' => 'destroy'
        ], 200);
    }
}
