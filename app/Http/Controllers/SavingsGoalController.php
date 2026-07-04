<?php

namespace App\Http\Controllers;

use App\Models\SavingsGoal;
use Illuminate\Http\Request;

class SavingsGoalController extends Controller
{
    public function index()
    {
        $goals = SavingsGoal::where('user_id', auth()->id())->latest()->get();
        return view('savings.index', compact('goals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'target_amount'  => 'required|numeric|min:1000',
            'current_amount' => 'nullable|numeric|min:0',
            'deadline'       => 'nullable|date|after:today',
            'icon'           => 'nullable|string|max:10',
        ]);

        SavingsGoal::create([
            'user_id'        => auth()->id(),
            'name'           => $request->name,
            'target_amount'  => $request->target_amount,
            'current_amount' => $request->current_amount ?? 0,
            'deadline'       => $request->deadline,
            'icon'           => $request->icon ?? '🎯',
        ]);

        return redirect()->route('savings.index')->with('success', 'Target tabungan berhasil ditambahkan!');
    }

    public function update(Request $request, SavingsGoal $saving)
    {
        $request->validate([
            'current_amount' => 'required|numeric|min:0',
        ]);

        $saving->update(['current_amount' => $request->current_amount]);

        return redirect()->route('savings.index')->with('success', 'Progress tabungan diperbarui!');
    }

    public function destroy(SavingsGoal $saving)
    {
        $saving->delete();
        return redirect()->route('savings.index')->with('success', 'Target tabungan dihapus!');
    }
}
