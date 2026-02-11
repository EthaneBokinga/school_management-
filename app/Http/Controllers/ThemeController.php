<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function setTheme(Request $request)
    {
        $theme = $request->input('theme', 'light');
        
        if (!in_array($theme, ['light', 'dark'])) {
            $theme = 'light';
        }
        
        session(['theme' => $theme]);
        
        return response()->json(['success' => true, 'theme' => $theme]);
    }
}
