<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user         = auth()->user();
        $totalTrx     = \App\Models\Transaction::where('user_id', $user->id)->count();
        $totalKat     = \App\Models\Category::where('user_id', $user->id)->count();
        $totalMasuk   = \App\Models\Transaction::where('user_id', $user->id)->where('type', 'pemasukan')->sum('amount');
        $totalKeluar  = \App\Models\Transaction::where('user_id', $user->id)->where('type', 'pengeluaran')->sum('amount');

        return view('profile', compact('user', 'totalTrx', 'totalKat', 'totalMasuk', 'totalKeluar'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            // Hapus foto lama kalau ada
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile')->with('success', 'Password berhasil diubah!');
    }
}
