<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LegalController extends Controller
{
    /**
     * Exibe a Política de Privacidade.
     */
    public function privacidade(): View
    {
        return view('legal.privacidade');
    }
}
