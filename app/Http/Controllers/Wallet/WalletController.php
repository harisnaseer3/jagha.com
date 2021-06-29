<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FooterController;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        dd( (new \App\Models\UserWallet)->getCurrentCredit());
        $wallet_id = (new \App\Models\UserWallet)->getUserWallet(Auth::user()->id);
        $history = array();
        $transaction = array();
        if ($wallet_id) {
            $history = DB::table('wallet_history')->where('user_wallet_id', $wallet_id->id)->get()->toArray();

            $packages = DB::table('packages')->select('id')->where('user_id', Auth::user()->id)->get()->pluck('id')->toArray();

            if (!empty($packages)) {
                $transaction = DB::table('package_transactions')->whereIn('package_id', $packages)->where('status','completed')->orderBy('id','DESC')->get();
            }

        }


        $data = [
            'history' => $history,
            'transaction' => $transaction,
            'wallet' => (new \App\Models\UserWallet)->getCurrentCredit(),
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1]
        ];
        return view('website.wallet.wallet', $data);
    }

    public function addCredit($user_id, $amount)
    {
        $credit_id = 0;

        $user_wallet = (new \App\Models\UserWallet)->getUserWallet($user_id);
        if ($user_wallet) {
            $user_wallet->current_credit = intval($user_wallet->current_credit) + $amount;
            $user_wallet->save();
            $credit_id = $user_wallet->id;
        } else {
            $credit_id = DB::Table('User_wallet')->insertGetId([
                'user_id' => $user_id,
                'current_credit' => $amount,
            ]);
        }

        DB::Table('wallet_history')->insert([
            'user_wallet_id' => $credit_id,
            'debit' => $amount  //added money in account
        ]);
    }

    public function withdrawCredit($user_id, $amount)
    {
        $credit_id = 0;

        $user_wallet = (new \App\Models\UserWallet)->getUserWallet($user_id);
        if ($user_wallet) {
            $user_wallet->current_credit = intval($user_wallet->current_credit) - $amount;
            $user_wallet->save();
            $credit_id = $user_wallet->id;
        }
//        else {
//            $credit_id = DB::Table('User_wallet')->insertGetId([
//                'user_id' => $user_id,
//                'current_credit' => $amount,
//            ]);
//        }

        DB::Table('wallet_history')->insert([
            'user_wallet_id' => $credit_id,
            'credit' => $amount   //widhraw money in account
        ]);
    }
}
