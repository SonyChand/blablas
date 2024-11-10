<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letters\IncomingLetter;
use App\Models\Letters\OutgoingLetter;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $incomingLettersCount = IncomingLetter::count();
        $outgoingLettersCount = OutgoingLetter::count();

        return view('dashboard.index', compact('incomingLettersCount', 'outgoingLettersCount'));
    }
}
