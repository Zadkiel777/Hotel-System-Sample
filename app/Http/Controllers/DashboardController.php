<?php
namespace App\Http\Controllers;

use App\Models\User; // Make sure to import your User model
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch all users. We use select() to explicitly exclude the 'password' column 
        // for security, even though we won't print it.
        $users = User::select('id', 'name', 'email', 'age', 'course', 'role', 'profile', 'created_at')
            ->get();

        // Pass the $users collection to the 'dashboard' view
        return view('dashboard', ['admin' => $users]);
    }
}