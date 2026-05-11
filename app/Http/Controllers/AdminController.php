<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bet;
use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{public function dashboard()
{
    $totalUsers = User::count();

    $totalDeposit = Deposit::where('status', 'approved')->sum('amount');
    $totalWithdraw = Withdrawal::where('status', 'approved')->sum('amount');
    $totalBet = Bet::sum('amount');

    // Last 5
    $lastBets = Bet::with('user')->latest()->take(5)->get();
    $lastWinners = Bet::with('user')
        ->where('status', 1)
        ->latest()
        ->take(5)
        ->get();

    $lastDeposits = Deposit::with('user')->latest()->take(5)->get();
    $lastWithdrawals = Withdrawal::with('user')->latest()->take(5)->get();

    // Simple profit calculation (example)
    $profit = $totalBet - ($totalDeposit + $totalWithdraw);

    return view('admin.dashboard', compact(
        'totalUsers',
        'totalDeposit',
        'totalWithdraw',
        'totalBet',
        'lastBets',
        'lastWinners',
        'lastDeposits',
        'lastWithdrawals',
        'profit'
    ));
}
    public function users()
    {
        $users = User::latest()->get();

        return view('admin.users', compact('users'));
    }

    public function bets()
    {
        $bets = Bet::with('user')->latest()->get();

        return view('admin.bets', compact('bets'));
    }

    public function deposits()
    {
        $deposits = Deposit::with('user')->latest()->get();

        return view('admin.deposits', compact('deposits'));
    }

    public function approveDeposit($id)
    {
        DB::transaction(function () use ($id) {

            $deposit = Deposit::findOrFail($id);

            if ($deposit->status != 'pending') {
                return;
            }

            $user = User::find($deposit->user_id);

            $user->wallet += $deposit->amount;
            $user->save();

            $deposit->status = 'approved';
            $deposit->save();
        });

        return back()->with('success', 'Deposit Approved');
    }

    public function withdrawals()
    {
        $withdrawals = Withdrawal::with('user')->latest()->get();

        return view('admin.withdrawals', compact('withdrawals'));
    }

    public function approveWithdrawal($id)
    {
        $withdraw = Withdrawal::findOrFail($id);

        $withdraw->status = 'approved';
        $withdraw->save();

        return back()->with('success', 'Withdrawal Approved');
    }

    public function rounds()
    {
        $rounds = Round::latest()->get();

        return view('admin.rounds', compact('rounds'));
    }
    public function rejectWithdrawal($id)
{
    $withdraw = Withdrawal::findOrFail($id);

    $withdraw->status = 'rejected';
    $withdraw->save();

    return back()->with('success', 'Withdrawal rejected');
}
public function rejectDeposit($id)
{
    $deposit = Deposit::findOrFail($id);

    $deposit->status = 'rejected';
    $deposit->save();

    return back()->with('success', 'Deposit rejected');
}
}