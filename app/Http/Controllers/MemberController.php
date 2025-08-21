<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return response()->json(Member::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:members',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $member = Member::create($request->all());
        return response()->json($member, 201);
    }
}
