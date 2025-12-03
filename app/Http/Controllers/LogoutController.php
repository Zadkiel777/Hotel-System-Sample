<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // 1. Log the user out (Removes all session data related to the user)
        Auth::logout();

        // 2. Invalidate the current session (Ensures the old session is no longer usable)
        $request->session()->invalidate();

        // 3. Regenerate the CSRF token (For security against session fixation attacks)
        $request->session()->regenerateToken();

        // 4. Redirect the user to a specific page after logout (e.g., the login page)
        return redirect('/login');
    }
}