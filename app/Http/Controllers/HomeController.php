<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        // Redirection selon le rôle
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isProf()) {
            return redirect()->route('prof.dashboard');
        }

        if ($user->isEleve()) {
            return redirect()->route('eleve.dashboard');
        }

        // Si aucun rôle reconnu
        abort(403, 'Rôle non reconnu');
    }
}