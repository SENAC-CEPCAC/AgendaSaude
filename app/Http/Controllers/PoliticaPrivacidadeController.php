<?php

namespace App\Http\Controllers;

use App\Models\AceitePolitica;
use App\Models\PoliticaPrivacidade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PoliticaPrivacidadeController extends Controller
{

    public function privacidade(): View
    {      

        return view('pesquisa.politicasprivacidade');
    }

}