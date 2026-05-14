<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bet;
use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function bets(Request $request)
{
    $query = Bet::with('user')->latest();

    // DATE FILTER
    if ($request->from && $request->to) {
        $query->whereBetween('created_at', [
            $request->from . ' 00:00:00',
            $request->to . ' 23:59:59'
        ]);
    }

    $bets = $query->get();

    // STATISTICS
    $totalBet = Bet::sum('amount');
    $totalWin = Bet::where('status', 1)->sum('amount');
    $totalLoss = Bet::where('status', 2)->sum('amount');
    $totalCancel = Bet::where('status', 3)->sum('amount');

    return view('admin.bets', compact(
        'bets',
        'totalBet',
        'totalWin',
        'totalLoss',
        'totalCancel'
    ));
}

   public function deposits(Request $request)
{
    $query = Deposit::with('user');

    // DATE FILTER
    if ($request->from && $request->to) {
        $query->whereBetween('created_at', [$request->from, $request->to]);
    }

    $deposits = $query->latest()->get();

    // STATS (ALL DATA - NOT FILTERED OR YOU CAN CHANGE)
    $totalDeposit = Deposit::where('status', 'approved')->sum('amount');

    $pendingDeposit = Deposit::where('status', 'pending')->sum('amount');

    $approvedCount = Deposit::where('status', 'approved')->sum('amount');

    $rejectedCount = Deposit::where('status', 'rejected')->sum('amount');

    return view('admin.deposits', compact(
        'deposits',
        'totalDeposit',
        'pendingDeposit',
        'approvedCount',
        'rejectedCount'
    ));
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

 public function withdrawals(Request $request)
{
    $query = Withdrawal::with('user')->latest();

    // DATE FILTER
    if ($request->from && $request->to) {
        $query->whereBetween('created_at', [
            $request->from . ' 00:00:00',
            $request->to . ' 23:59:59'
        ]);
    }

    $withdrawals = $query->get();

    // STATISTICS
    $totalWithdraw = Withdrawal::sum('amount');
    $pendingWithdraw = Withdrawal::where('status', 'pending')->sum('amount');
    $approvedWithdraw = Withdrawal::where('status', 'approved')->sum('amount');
    $rejectedWithdraw = Withdrawal::where('status', 'rejected')->sum('amount');

    return view('admin.withdrawals', compact(
        'withdrawals',
        'totalWithdraw',
        'pendingWithdraw',
        'approvedWithdraw',
        'rejectedWithdraw'
    ));
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
/*
    |--------------------------------------------------------------------------
    | CREATE USER
    |--------------------------------------------------------------------------
    */

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'wallet' => 'required|numeric',
            'password' => 'required|min:6',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'wallet' => $request->wallet,
            'password' => Hash::make($request->password),
            'password_txt' => $request->password,
            'is_promoter' => $request->promoter,
            'is_vip' => $request->vip,
           'status' => $request->status,
        ]);

        return back()->with('success', 'User Created Successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE USER
    |--------------------------------------------------------------------------
    */

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'wallet' => 'required|numeric',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;
        $user->wallet = $request->wallet;
        $user->is_promoter = $request->promoter;
        $user->is_vip = $request->vip;
        $user->status = $request->status;
        

        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->password_txt=$request->password;
        }

        $user->save();

        return back()->with('success', 'User Updated Successfully');
    }
    public function deleteUser($id)
{
    $user = User::findOrFail($id);

    $user->delete();

    return back()->with('success', 'User Deleted Successfully');
}
public function profile(Request $request, $id)
{
    $user = User::findOrFail($id);

    $from = $request->from;
    $to = $request->to;

    $deposits = Deposit::where('user_id', $id);

    $withdrawals = Withdrawal::where('user_id', $id);

    $bets = Bet::where('user_id', $id);

    // DATE FILTER
    if ($from && $to) {

        $deposits->whereBetween('created_at', [$from, $to]);

        $withdrawals->whereBetween('created_at', [$from, $to]);

        $bets->whereBetween('created_at', [$from, $to]);
    }

    $deposits = $deposits->latest()->get();
    $withdrawals = $withdrawals->latest()->get();
    $bets = $bets->latest()->get();

    $totalDeposit = $deposits->sum('amount');
$totalWithdraw = $withdrawals->sum('amount');
$totalBet = $bets->sum('amount');

return view('admin.profile', compact(
    'user',
    'deposits',
    'withdrawals',
    'bets',
    'from',
    'to',
    'totalDeposit',
    'totalWithdraw',
    'totalBet'
));
}
public function markBetsPaid(Request $request)
{
    $request->validate([
        'from' => 'required|date',
        'to' => 'required|date',
    ]);

    Bet::whereBetween('created_at', [$request->from, $request->to])
        ->update([
            'is_paid' => 1
        ]);

    return back()->with('success', 'Selected date bets marked as PAID');
}
}