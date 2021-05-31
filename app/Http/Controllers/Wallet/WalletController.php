<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FooterController;
use App\Models\UserWallet;
use Illuminate\Http\Request;

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
        $data = [
            'wallet' => (new \App\Models\UserWallet)->getCurrentCredit(),
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1]
        ];
        return view('website.account.wallet', $data);
    }

}
