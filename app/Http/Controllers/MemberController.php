<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->role, ['admin', 'librarian'])) {
            $members = Member::all();
        } else {
            // Member hanya bisa lihat data dirinya sendiri
            $members = Member::where('user_id', $user->id)->get();
        }

        return view('members.index', compact('members'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'librarian'])) {
            abort(403, 'Anda tidak memiliki izin untuk menambahkan anggota.');
        }

        return view('members.form');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'librarian'])) {
            abort(403, 'Anda tidak memiliki izin untuk menambahkan anggota.');
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:members',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        Member::create($request->all());
        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function edit(Member $member)
    {
        $user = Auth::user();

        if ($user->role === 'member' && $member->user_id !== $user->id) {
            abort(403, 'Anda tidak boleh mengedit data anggota lain.');
        }

        return view('members.form', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $user = Auth::user();

        if ($user->role === 'member' && $member->user_id !== $user->id) {
            abort(403, 'Anda tidak boleh mengupdate data anggota lain.');
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:members,email,' . $member->id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $member->update($request->all());
        return redirect()->route('members.index')->with('success', 'Anggota berhasil diperbarui!');
    }

    public function destroy(Member $member)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'librarian'])) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus anggota.');
        }

        $member->delete();
        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus!');
    }
}
