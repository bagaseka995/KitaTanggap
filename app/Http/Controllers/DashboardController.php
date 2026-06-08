<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Redirect users to their respective dashboards based on their role.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        return match ($user->peran) {
            'admin'   => redirect()->route('admin.dashboard'),
            'relawan' => redirect()->route('relawan.dashboard'),
            'donatur' => redirect()->route('donatur.dashboard'),
            default   => redirect('/'),
        };
    }
}
