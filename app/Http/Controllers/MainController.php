<?php

namespace App\Http\Controllers;

use app\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;


class MainController extends Controller
{
    /**
     * Show the main welcome page.
     */
    public function main(){
        return view('welcome');
    }

    /**
     * Show the registration form view.
     */
    public function register(){
        // Assumes your registration blade file is at resources/views/register.blade.php
        return view('register');
    }


    public function addroom(){
        // Assumes your add room blade file is at resources/views/addroom.blade.php
        return view('addroom');
    }


    /**
     * Display the Checkout / Invoice page.
     */
    public function showCheckout($id)
{
    // 1. UPDATED CHECK: Allow if Admin (id) OR Customer (customer_id) is logged in
    if (!Session::has('id') && !Session::has('customer_id')) {
        return redirect()->route('main')->with('error', 'Please log in to access this page.');
    }

    // 2. Fetch booking (Rest of the code remains the same)
    $booking = DB::table('booking')
        ->join('customers', 'booking.customer_id', '=', 'customers.id')
        ->join('room', 'booking.room_id', '=', 'room.id')
        ->leftJoin('payment', 'payment.booking_id', '=', 'booking.id') 
        ->where('booking.id', $id)
        ->select(
            'booking.*', 
            'customers.Fname', 'customers.Lname', 'customers.email', 'customers.contact',
            'room.room_number', 'room.room_type', 
            'payment.amount as paid_amount'
        )
        ->first();

    if (!$booking) {
        return redirect()->back()->with('error', 'Booking not found.');
    }

    // 3. Security Check: If it's a customer, ensure they own this booking
    if (Session::has('customer_id')) {
        if ($booking->customer_id != Session::get('customer_id')) {
            return redirect()->route('customerDashboard')->with('error', 'Unauthorized access.');
        }
    }

    // 4. Calculate Nights
    $checkIn = new \DateTime($booking->check_in_date);
    $checkOut = new \DateTime($booking->check_out_date);
    $nights = max(1, $checkIn->diff($checkOut)->days);

    // 5. Calculate Rate
    $rates = [
        'Standard' => 2000,
        'Deluxe' => 3000,
        'Luxury' => 4500,
    ];
    $ratePerNight = $rates[$booking->room_type] ?? 2500;
    
    return view('checkout', compact('booking', 'nights', 'ratePerNight'));
}

    /**
     * Process the Checkout (Update DB).
     */
    public function checkoutBooking(Request $request, $id)
{
    // 1. Validate the new input
    $request->validate([
        'payment_option' => 'required|string'
    ]);

    // 2. Auth Check
    if (!Session::has('id') && !Session::has('customer_id')) {
        return redirect()->route('main')->with('error', 'Unauthorized.');
    }

    $booking = DB::table('booking')->where('id', $id)->first();

    if (!$booking || $booking->status === 'Completed') {
        return redirect()->back()->with('error', 'Booking invalid or already completed.');
    }

    // 3. Calculate Outstanding Balance
    $total = $booking->total_amount;
    $alreadyPaid = DB::table('payment')->where('booking_id', $id)->sum('amount');
    $balance = $total - $alreadyPaid;

    // 4. Record the Payment (If there is a balance)
    // We assume the checkout pays off the remaining balance
    if ($balance > 0) {
        DB::table('payment')->insert([
            'booking_id' => $id,
            'customer_id' => $booking->customer_id,
            'payment_option' => $request->payment_option, // <--- Value from your new dropdown
            'amount' => $balance,
            'paid_at' => now()
        ]);
    }

    // 5. Update Status to Completed
    DB::table('booking')
        ->where('id', $id)
        ->update([
            'status' => 'Completed',
            'updated_at' => now(),
        ]);

    // 6. Free up the room
    DB::table('room')
        ->where('id', $booking->room_id)
        ->update(['status' => 'Available']);

    // 7. Log Activity
    $actorId = Session::get('id') ?? Session::get('customer_id');
    $this->logActivity(
        $actorId, 
        'Checkout', 
        "Processed checkout via {$request->payment_option}. Paid: {$balance}", 
        $booking->id, 
        'booking'
    );

    // Redirect based on who is logged in
    if(Session::has('id')) {
        return redirect()->route('bookedRooms')->with('success', 'Checkout processed successfully.');
    } else {
        return redirect()->route('customerDashboard')->with('success', 'Thank you! Your checkout is complete.');
    }
}


    public function customerDashboard(){
        // If a customer is not logged in, show an empty but friendly 
        if (!Session::has('customer_id')) {
        return redirect()->route('main')->with('error', 'Access Denied.');
        }

        $customerId = Session::get('customer_id');

        if (!$customerId) {
            $bookings = collect();
            $nextBooking = null;
            return view('customerDashboard', compact('bookings', 'nextBooking'));
        }

        // Fetch this customer's bookings with room information
        $bookings = DB::table('booking')
            ->join('room', 'booking.room_id', '=', 'room.id')
            ->where('booking.customer_id', $customerId)
            ->select(
                'booking.id',
                'booking.check_in_date',
                'booking.check_out_date',
                'booking.status',
                'booking.total_amount',
                'room.room_number',
                'room.room_type'
            )
            ->orderBy('booking.check_in_date', 'desc')
            ->get();

        // Find the next upcoming booking (check-in date today or in future, not cancelled)
        $nextBooking = $bookings
            ->filter(function ($b) {
                return in_array($b->status, ['Pending', 'Confirmed', 'Occupied']) &&
                    $b->check_in_date >= date('Y-m-d');
            })
            ->sortBy('check_in_date')
            ->first();

        return view('customerDashboard', compact('bookings', 'nextBooking'));
    }

    public function guestbooking(){
        return view('guestbooking');
    }

    public function memberBooking(){
        // Only allow logged-in customers to access this form
        if (!Session::has('customer_id')) {
            return redirect()->route('main')
                ->with('error', 'Please log in to your account to use the member booking form.');
        }

        return view('memberBooking');
    }


    public function bookedRooms(Request $request)
{
    $search = $request->input('search');

    // 1. Start with the booking table
    $query = DB::table('booking')
        // Join with Customers to get names
        ->join('customers', 'booking.customer_id', '=', 'customers.id')
        // Join with Room to get room number and type
        ->join('room', 'booking.room_id', '=', 'room.id')
        ->select(
            'booking.id',
            'customers.Fname',
            'customers.Lname',
            'customers.customer_type',
            'room.room_number',
            'room.room_type',
            'booking.check_in_date',
            'booking.check_out_date',
            'booking.status'
        );

    // 2. Apply Search Logic (if user types in the search bar)
    if ($search) {
        $searchTerms = explode(' ', $search);

        foreach ($searchTerms as $term) {
            $query->where(function ($q) use ($term) {
                $term = "%{$term}%";
                $q->where('customers.Fname', 'like', $term)
                  ->orWhere('room.room_type', 'like', $term)
                  ->orWhere('customers.Lname', 'like', $term)
                  ->orWhere('room.room_number', 'like', $term)
                  ->orWhere('customers.customer_type', $term) // Allow searching by Room Number
                  ->orWhere('booking.status', 'like', $term);  // Allow searching by Status (e.g., "Pending")
            });
        }
    }

    // 3. Order by newest bookings first and paginate
    $bookings = $query->orderBy('booking.created_at', 'desc') 
                    ->simplePaginate(10);

    // Keep search term in pagination links
    if ($search) {
        $bookings->appends(['search' => $search]);
    }

    return view('bookedRooms', compact('bookings', 'search'));
}

public function viewBooking($id)
{
    // Fetch booking details with customer and room information
    $booking = DB::table('booking')
        ->join('customers', 'booking.customer_id', '=', 'customers.id')
        ->join('room', 'booking.room_id', '=', 'room.id')
        ->leftJoin('payment', 'payment.booking_id', '=', 'booking.id')
        ->where('booking.id', $id)
        ->select(
            'booking.id',
            'booking.customer_id',
            'booking.room_id',
            'booking.check_in_date',
            'booking.check_out_date',
            'booking.status',
            'booking.total_amount',
            'booking.created_at',
            'customers.Fname',
            'customers.Lname',
            'customers.email',
            'customers.contact',
            'customers.dob',
            'room.room_number',
            'room.room_type',
            'room.status as room_status',
            'payment.id as payment_id',
            'payment.payment_option',
            'payment.amount as payment_amount',
            'payment.paid_at'
        )
        ->first();

    if (!$booking) {
        return redirect()->route('bookedRooms')->with('error', 'Booking not found.');
    }

    return view('viewBooking', compact('booking'));
}

public function customerViewBooking($id)
{
    $customerId = Session::get('customer_id');
    if (!$customerId) {
        return redirect()->route('main')->with('error', 'Please log in to view your bookings.');
    }

    $booking = DB::table('booking')
        ->join('customers', 'booking.customer_id', '=', 'customers.id')
        ->join('room', 'booking.room_id', '=', 'room.id')
        ->where('booking.id', $id)
        ->where('booking.customer_id', $customerId)
        ->select(
            'booking.id',
            'booking.customer_id',
            'booking.room_id',
            'booking.check_in_date',
            'booking.check_out_date',
            'booking.status',
            'booking.total_amount',
            'booking.created_at',
            'customers.Fname',
            'customers.Lname',
            'customers.email',
            'customers.contact',
            'room.room_number',
            'room.room_type'
        )
        ->first();

    if (!$booking) {
        return redirect()->route('customerDashboard')->with('error', 'Booking not found.');
    }

    // Derive nights and rate per night (based on same simple rate map)
    $checkIn  = new \DateTime($booking->check_in_date);
    $checkOut = new \DateTime($booking->check_out_date);
    $nights   = max(1, $checkIn->diff($checkOut)->days);

    $rates = [
        'Standard' => 2000,
        'Deluxe' => 3000,
        'Luxury' => 4500,
    ];
    $ratePerNight = $rates[$booking->room_type] ?? 2500;

    $booking->nights = $nights;
    $booking->rate_per_night = $ratePerNight;

    return view('customerViewBooking', compact('booking'));
}

public function customerCancelBooking(Request $request, $id)
{
    $customerId = Session::get('customer_id');
    if (!$customerId) {
        return redirect()->route('main')->with('error', 'Please log in to manage your bookings.');
    }

    $booking = DB::table('booking')
        ->where('id', $id)
        ->where('customer_id', $customerId)
        ->first();

    if (!$booking) {
        return redirect()->route('customerDashboard')->with('error', 'Booking not found.');
    }

    if (!in_array($booking->status, ['Pending', 'Confirmed'])) {
        return redirect()->route('customer.viewBooking', $id)
            ->with('error', 'Only pending or confirmed bookings can be cancelled.');
    }

    DB::table('booking')
        ->where('id', $id)
        ->update([
            'status' => 'Cancelled',
            'updated_at' => now(),
        ]);

    // Free up the room
    DB::table('room')
        ->where('id', $booking->room_id)
        ->update(['status' => 'Available']);

    $this->logActivity($customerId, 'Booking Cancelled', "Member cancelled booking #{$booking->id}");

    return redirect()->route('customerDashboard')
        ->with('success', 'Your booking has been cancelled.');
}

public function updateBookingStatus(Request $request, $id)
{
    $request->validate([
        'status' => ['required', 'string', 'in:Pending,Confirmed,Cancelled,Occupied,Completed'],
    ]);

    $booking = DB::table('booking')->where('id', $id)->first();

    if (!$booking) {
        return redirect()->route('bookedRooms')->with('error', 'Booking not found.');
    }

    $newStatus = $request->status;

    // Update booking status
    DB::table('booking')
        ->where('id', $id)
        ->update([
            'status' => $newStatus,
            'updated_at' => now(),
        ]);

    // Sync room status with booking status where appropriate
    if (in_array($newStatus, ['Cancelled', 'Completed'])) {
        DB::table('room')
            ->where('id', $booking->room_id)
            ->update(['status' => 'Available']);
    } elseif ($newStatus === 'Occupied') {
        DB::table('room')
            ->where('id', $booking->room_id)
            ->update(['status' => 'Occupied']);
    }

    // Log activity
    $adminId = Session::get('id');
    if ($adminId) {
        $this->logActivity(
            $adminId,
            'Booking Status Updated',
            "Updated booking #{$booking->id} status to {$newStatus}",
            $booking->id,
            'booking'
        );
    }

    return redirect()
        ->route('viewBooking', $id)
        ->with('success', 'Booking status updated successfully.');
}

public function storeBookingPayment(Request $request, $id)
{
    $booking = DB::table('booking')->where('id', $id)->first();

    if (!$booking) {
        return redirect()->route('bookedRooms')->with('error', 'Booking not found.');
    }

    $request->validate([
        'payment_option' => ['required', 'string', 'max:100'],
        'amount' => ['required', 'numeric', 'min:0'],
    ]);

    // Either create or update a single payment record per booking
    $existingPayment = DB::table('payment')->where('booking_id', $id)->first();

    if ($existingPayment) {
        DB::table('payment')
            ->where('id', $existingPayment->id)
            ->update([
                'payment_option' => $request->payment_option,
                'amount' => $request->amount,
                'paid_at' => now(),
            ]);
    } else {
        DB::table('payment')->insert([
            'booking_id' => $booking->id,
            'customer_id' => $booking->customer_id,
            'payment_option' => $request->payment_option,
            'amount' => $request->amount,
            'paid_at' => now(),
        ]);
    }

    // Update booking total_amount and optionally status
    $newTotal = (float) $request->amount;

    DB::table('booking')
        ->where('id', $id)
        ->update([
            'total_amount' => $newTotal,
            'status' => $booking->status === 'Pending' ? 'Confirmed' : $booking->status,
            'updated_at' => now(),
        ]);

    // Log activity
    $adminId = Session::get('id');
    if ($adminId) {
        $this->logActivity(
            $adminId,
            'Payment Recorded',
            "Recorded payment for booking #{$booking->id}, amount ₱{$newTotal}",
            $booking->id,
            'booking'
        );
    }

    return redirect()
        ->route('viewBooking', $id)
        ->with('success', 'Payment recorded successfully.');
}



public function guest_book_room(Request $request)
{
    // If a member is logged in, redirect them to the member booking form
    if (Session::has('customer_id')) {
        return redirect()->route('memberBooking')
            ->with('error', 'You are logged in as a member. Please use the member booking form.');
    }

    // 1. Validate the form data
    $request->validate([
        'check_in' => 'required|date|after_or_equal:today',
        'check_out' => 'required|date|after:check_in',
        'room_type' => 'required|string',
        'guests' => 'required',
        // Guest-only booking requires full details
        'fname' => 'required|string',
        'lname' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required|string',
    ]);

    // 2. Determine Customer ID for a pure guest booking
    // Check if this email already exists in customers table
    $existingCustomer = DB::table('customers')->where('email', $request->email)->first();

    if ($existingCustomer) {
        $customerId = $existingCustomer->id;
    } else {
        // Create a new customer record as Guest
        $customerId = DB::table('customers')->insertGetId([
            'Fname' => $request->fname,
            'Lname' => $request->lname,
            'email' => $request->email,
            'contact' => $request->phone,
            'customer_type' => 'Guest',
            'password' => '', // No password for guest accounts
            'dob' => null,
            'profile' => 'images/default_profile.png',
            'created_at' => now()
        ]);
    }

    // 3. Find an Available Room of the requested type
    $room = DB::table('room')
        ->where('room_type', $request->room_type)
        ->where(function($q) {
            $q->where('status', 'Available')
              ->orWhere('status', 'available');
        })
        ->first();

    // If no room is found, redirect back with error
    if (!$room) {
        return redirect()->back()->with('error', "Sorry, no {$request->room_type} rooms are currently available.");
    }

    // 4. Compute simple total amount (rate per night x nights)
    $checkIn  = new \DateTime($request->check_in);
    $checkOut = new \DateTime($request->check_out);
    $nights = max(1, $checkIn->diff($checkOut)->days);

    // Simple hard-coded rate map; could be moved to a config or table later
    $rates = [
        'Standard' => 2000,
        'Deluxe' => 3000,
        'Luxury' => 4500,
    ];
    $ratePerNight = $rates[$room->room_type] ?? 2500;
    $totalAmount = $ratePerNight * $nights;

    // 5. Create the Booking
    DB::table('booking')->insert([
        'customer_id' => $customerId,
        'room_id' => $room->id,
        'check_in_date' => $request->check_in,
        'check_out_date' => $request->check_out,
        'status' => 'Pending',
        'total_amount' => $totalAmount,
        'created_at' => now()
    ]);

    // 6. Update the Room Status
    DB::table('room')->where('id', $room->id)->update(['status' => 'Occupied']);

    // 7. Log Activity
    if (Session::has('id')) {
        $this->logActivity(Session::get('id'), 'Room Booked', "Booked Room {$room->room_number}");
    }

    return redirect()->route('main')->with('success', 'Booking submitted successfully! We will contact you shortly.');
}

public function member_book_room(Request $request)
{
    // Only allow logged-in customers
    if (!Session::has('customer_id')) {
        return redirect()->route('main')
            ->with('error', 'Please log in to your account to book as a member.');
    }

    // 1. Validate the form data
    $request->validate([
        'check_in' => 'required|date|after_or_equal:today',
        'check_out' => 'required|date|after:check_in',
        'room_type' => 'required|string',
        'guests' => 'required',
    ]);

    // Logged-in member
    $customerId = Session::get('customer_id');

    // 3. Find an Available Room of the requested type
    $room = DB::table('room')
        ->where('room_type', $request->room_type)
        ->where(function($q) {
            $q->where('status', 'Available')
            ->orWhere('status', 'available');
        })
        ->first();

    if (!$room) {
        return redirect()->back()->with('error', "Sorry, no {$request->room_type} rooms are currently available.");
    }

    // 4. Compute simple total amount (rate per night x nights)
    $checkIn  = new \DateTime($request->check_in);
    $checkOut = new \DateTime($request->check_out);
    $nights = max(1, $checkIn->diff($checkOut)->days);

    $rates = [
        'Standard' => 2000,
        'Deluxe' => 3000,
        'Luxury' => 4500,
    ];
    $ratePerNight = $rates[$room->room_type] ?? 2500;
    $totalAmount = $ratePerNight * $nights;

    // 5. Create the Booking
    $bookingId = DB::table('booking')->insertGetId([
        'customer_id' => $customerId,
        'room_id' => $room->id,
        'check_in_date' => $request->check_in,
        'check_out_date' => $request->check_out,
        'status' => 'Pending',
        'total_amount' => $totalAmount,
        'created_at' => now()
    ]);

    // 6. Update the Room Status
    DB::table('room')->where('id', $room->id)->update(['status' => 'Occupied']);

    // 7. Log Activity
    $this->logActivity($customerId, 'Room Booked', "Member booked Room {$room->room_number} (Booking #{$bookingId})");

    return redirect()->route('customerDashboard')
        ->with('success', 'Your booking has been submitted successfully!');
}



    public function save_room(Request $request)
    {
        // 1. Validate the input
        $request->validate([
            'picture'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'], // Max 5MB
            'room_number' => ['required', 'string', 'max:255', 'unique:room,room_number'],
            'room_type'   => ['required', 'string', 'max:255'],
            'status'      => ['required', 'string', 'max:255'],
        ]);

        // 2. Set a Default Image Path (Optional)
        // If they don't upload a picture, you might want a placeholder.
        // Ensure you have a default image at public/images/default_room.png, or set this to null.
        $picturePath = 'images/default_room.png'; 

        // 3. Handle the File Upload
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            
            // Define where you want to store room images
            $uploadPath = public_path('uploads/rooms');
            
            // Create the directory if it does not exist
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Generate a unique filename to prevent overwriting
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Move the file to the public/uploads/rooms folder
            $file->move($uploadPath, $filename);
            
            // Update the variable to the new path to save in DB
            $picturePath = 'uploads/rooms/' . $filename;
        }

        // 4. Insert Data into Database
        DB::table('room')->insert([
            'picture'     => $picturePath, // We save the string path here
            'room_number' => $request->room_number,
            'room_type'   => $request->room_type,
            'status'      => $request->status,
        ]);
        
        // 5. Log activity
        $adminId = Session::get('id');
        if ($adminId) {
            $this->logActivity(
                $adminId, 
                'Room Added', 
                "Added new room: {$request->room_number} ({$request->room_type})", 
                null, 
                'room'
            );
        }
        
        $request->session()->flash('save_room');
        return redirect()->route('addroom')->with('success', 'Room added successfully!');
    }



public function save_user(Request $request)
{
    // 1. Validate input
    $request->validate([
        'email' => ['required', 'string', 'email', 'max:255', 'unique:customers,email'],
        'customers_type' => ['nullable', 'string', 'max:255'],
        'password' => ['required', 'string', 'min:3'],
        'Fname' => ['required', 'string', 'max:255'],
        'Lname' => ['required', 'string', 'max:255'],
        'contact' => ['required', 'string', 'max:15', 'unique:customers,contact'],
        'dob' => ['required', 'date'],
        'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'], // Max 5MB
    ]);

    // 2. Set Default Profile Picture Path
    // We set this immediately so even if no file is uploaded, they have a default image.
    $profilePath = 'images/default_profile.png'; 

    // 3. Handle Profile Picture Upload (Override default if file exists)
    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        
        // Create uploads directory if it doesn't exist
        $uploadPath = public_path('uploads');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);
        
        // Update the path to the new uploaded file
        $profilePath = 'uploads/' . $filename;
    }

    // 4. Check Database Schema (Optional safety check)
    // It is better to run this once in a migration file, but I will keep your logic here.
    $columnExists = DB::select("SHOW COLUMNS FROM customers LIKE 'profile'");
    if (empty($columnExists)) {
        try {
            DB::statement('ALTER TABLE customers ADD COLUMN profile VARCHAR(255) NULL AFTER dob');
        } catch (\Exception $e) {
            // Ignore if column exists
        }
    }

    // 5. Insert customer data
    DB::table('customers')->insert([
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'Fname' => $request->Fname,
        'Lname' => $request->Lname,
        'contact' => $request->contact,
        'customer_type' => $request->customers_type ?? 'Member',
        'dob' => $request->dob,
        'profile' => $profilePath, // <--- Now this always has a value
        'created_at' => now(), // Good practice to track when they joined
    ]);
    
    // 6. Log activity (Only if an Admin is adding the user)
    $adminId = Session::get('id');
    if ($adminId) {
        $this->logActivity($adminId, 'Customer Added', "Added new customer: {$request->Fname} {$request->Lname}", null, 'customer');
        
        // IF ADMIN: Redirect back to the user list
        $request->session()->flash('save_user');
        return redirect()->route('users')->with('success', 'Customer added successfully!');
    }
    
    // 7. IF GUEST (Public Registration): Redirect to Login Page
    // Since no admin session exists, this must be a public registration.
    return redirect()->route('main')->with('success', 'Account created successfully! Please login.');
}


public function auth_user(Request $request)
{
    // 1. Validate the incoming request
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $email = $request->email;
    $pass = $request->password;
    $loginType = $request->input('login_type'); // Expecting 'admin' or 'customer'

    // ==========================================
    // 1. ADMIN LOGIN LOGIC
    // ==========================================
    if ($loginType === 'admin') {
        $check_user = DB::table('admin')
            ->where('email', $email)
            ->first();

        if (!$check_user) {
            return redirect()->back()->with('error', 'No admin account found with this email.');
        }

        if (Hash::check($pass, $check_user->password)) {
            // CRITICAL: Clear all previous session data to prevent role crossover
            Session::flush();

            // Set Admin Specific Session Keys
            Session::put('id', $check_user->id ?? $check_user->usr_id);
            Session::put('profile', $check_user->profile ?? $check_user->usr_profile);
            Session::put('name', $check_user->name ?? $check_user->usr_name);
            Session::put('email', $check_user->email);
            Session::put('role', 'admin'); // Hardcoded 'admin' for security

            $this->logActivity(Session::get('id'), 'Login', 'Admin logged in successfully');

            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('error', 'Incorrect password for admin account.');
        }
    }

    // ==========================================
    // 2. CUSTOMER LOGIN LOGIC
    // ==========================================
    // If not 'admin', we treat as a customer login attempt
    $customer = DB::table('customers')
        ->where('email', $email)
        ->first();

    if (!$customer) {
        return redirect()->back()->with('error', 'No account found with this email. Please register first.');
    }

    // Handle Guests who don't have passwords
    if (empty($customer->password)) {
        return redirect()->back()->with('error', 'This is a Guest account. Please register to create a password.');
    }

    if (Hash::check($pass, $customer->password)) {
        // CRITICAL: Clear all previous session data (Wipes any Admin 'id' that might exist)
        Session::flush();

        // Set Customer Specific Session Keys
        Session::put('customer_id', $customer->id);
        Session::put('name', trim(($customer->Fname ?? '') . ' ' . ($customer->Lname ?? '')) ?: $customer->email);
        Session::put('email', $customer->email);
        Session::put('role', 'customer'); // Hardcoded 'customer' for security
        
        // Optional: you can still keep the specific customer type (Member/Guest) in a separate key
        Session::put('customer_type', $customer->customer_type ?? 'Member');

        return redirect()->route('customerDashboard');
    } else {
        return redirect()->back()->with('error', 'Incorrect password.');
    }
}


    /**
     * Show the dashboard view.
     */
    public function dashboard(){
        // Check if admin is logged in
        if (!Session::has('id')) {
            return redirect()->route('main')->with('error', 'Please log in as an admin to access the dashboard.');
        }

        // This is the destination page after a successful login!
        $totaladmin = DB::table('admin')->count();
        $totalrooms = DB::table('room')->distinct('room_type')->count('room_type');
        
        // Calculate booked/occupied rooms (case-insensitive)
        $allrooms = DB::table('room')
            ->whereRaw('LOWER(status) = ?', ['occupied'])
            ->count();
        
        // Calculate total available rooms (excluding unavailable rooms)
        // Available rooms are those with status 'Available' or 'Occupied' (not 'Unavailable')
        $totalAvailableRooms = DB::table('room')
            ->where(function($query) {
                $query->whereRaw('LOWER(status) = ?', ['available'])
                    ->orWhereRaw('LOWER(status) = ?', ['occupied']);
            })
            ->count();
        
        $totalcustomers= DB::table('customers')->count();
        $totalprofit= DB::table('payment')->sum('amount');

        $roomlabels = ['Standard', 'Deluxe', 'Luxury'];

$roomdata = [
    // Count occupied rooms by type (case-insensitive)
    DB::table('room')->where('room_type', 'Standard')->whereRaw('LOWER(status) = ?', ['occupied'])->count(),
    DB::table('room')->where('room_type', 'Deluxe')->whereRaw('LOWER(status) = ?', ['occupied'])->count(),
    DB::table('room')->where('room_type', 'Luxury')->whereRaw('LOWER(status) = ?', ['occupied'])->count(),
];

$monthlyPayments = DB::table('payment')
            ->select(
                DB::raw('SUM(amount) as total_amount'), // Get the total amount
                DB::raw('MONTHNAME(paid_at) as month_name'), // Get the month name
                DB::raw('MIN(paid_at) as month_date') // Used for sorting
            )
            ->whereYear('paid_at', date('Y')) // Only get data for the current year
            ->groupBy('month_name')
            ->orderBy('month_date', 'ASC') // Order by the date (Jan, Feb, Mar...)
            ->get();
            
        // Process the data for Chart.js
        // This creates: ['January', 'February', 'March', ...]
        $profitlabels = $monthlyPayments->pluck('month_name');
        
        // This creates: [1000.00, 1400.00, 1300.00, ...]
        $profitdata = $monthlyPayments->pluck('total_amount');

        return view('dashboard', compact('totaladmin', 'totalrooms', 'allrooms', 'totalAvailableRooms', 'totalcustomers',
        'roomlabels', 'roomdata', 'totalprofit', 'profitlabels', 'profitdata'));
    }


    

    private function logActivity($userId, $action, $description = null, $relatedId = null, $relatedType = null)
    {
        try {
            // Check if activities table exists
            $tableExists = DB::select("SHOW TABLES LIKE 'activities'");
            
            if (empty($tableExists)) {
                // Create activities table if it doesn't exist
                DB::statement("
                    CREATE TABLE IF NOT EXISTS `activities` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `user_id` int(11) NOT NULL,
                        `action` varchar(255) NOT NULL,
                        `description` text DEFAULT NULL,
                        `related_id` int(11) DEFAULT NULL,
                        `related_type` varchar(100) DEFAULT NULL,
                        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                        PRIMARY KEY (`id`),
                        KEY `user_id` (`user_id`),
                        KEY `created_at` (`created_at`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
                ");
            }
            
            // Insert activity log
            DB::table('activities')->insert([
                'user_id' => $userId,
                'action' => $action,
                'description' => $description,
                'related_id' => $relatedId,
                'related_type' => $relatedType,
                'created_at' => now()
            ]);
        } catch (\Exception $e) {
            // Silently fail if logging fails to not break the main functionality
            \Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }


    
    // The method to fetch the admin's profile data
    public function profile(){
        // ... (Your existing profile method)
        $adminId = Session::get('id');

        if (!$adminId) {
            return redirect()->route('main')->with('error', 'You must log in to view your profile.');
        }

        $admin = DB::table('admin')
            ->where('id', $adminId)
            ->select('id', 'profile', 'name', 'email', 'role')
            ->first();

        if (!$admin) {
            Session::forget(['id', 'profile', 'name', 'role']);
            return redirect()->route('main')->with('error', 'Session user not found. Please log in again.');
        }
        
        // Update session profile if it's not set or different
        if (!Session::has('profile') || Session::get('profile') !== $admin->profile) {
            Session::put('profile', $admin->profile);
        }
        
        // Fetch user activities
        $activities = [];
        try {
            $tableExists = DB::select("SHOW TABLES LIKE 'activities'");
            if (!empty($tableExists)) {
                $activities = DB::table('activities')
                    ->where('user_id', $adminId)
                    ->orderBy('created_at', 'desc')
                    ->limit(50) // Show last 50 activities
                    ->get();
            }
        } catch (\Exception $e) {
            // If activities table doesn't exist or error occurs, activities will be empty
            $activities = [];
        }
        
        return view('profile', compact('admin', 'activities'));
    }




public function users(Request $request)
{
    $search = $request->input('search');

    // Check if profile column exists
    $columnExists = DB::select("SHOW COLUMNS FROM customers LIKE 'profile'");
    
    $selectFields = ['id', 'Fname', 'Lname', 'email', 'customer_type', 'contact'];
    if (!empty($columnExists)) {
        $selectFields[] = 'profile';
    }

    $customerQuery = DB::table('customers')
        ->select($selectFields);

    // Only apply search logic if $search is not empty
    if ($search) {
        // ✅ Split the search string into individual words
        $searchTerms = explode(' ', $search);

        // ✅ Loop over each search word
        foreach ($searchTerms as $term) {
            
            // ✅ Group the 'OR' statements for each word
            // This ensures a record must match ALL words (AND logic)
            // but each word can be in ANY of the columns (OR logic)
            $customerQuery->where(function ($query) use ($term) {
                $term = "%{$term}%";
                $query->where('Fname', 'like', $term)
                    ->orWhere('Lname', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('customer_type', 'like', $term)
                    ->orWhere('contact', 'like', $term);
            });
        }
    }

    // Continue with ordering and pagination
    $customers = $customerQuery->orderBy('Lname', 'asc')
                         ->simplePaginate(10); // <-- show 10 users per page

    // Keep the search query in pagination links
    if ($search) {
        $customers->appends(['search' => $search]);
    }

    return view('users', compact('customers', 'search'));
}



    public function studentProfile($id)
{
    // Check if profile column exists
    $columnExists = DB::select("SHOW COLUMNS FROM customers LIKE 'profile'");
    
    // Fetch the specific student by ID
    $selectFields = ['id', 'Fname', 'Lname', 'email', 'customer_type', 'contact', 'dob', 'created_at'];
    if (!empty($columnExists)) {
        $selectFields[] = 'profile';
    }
    
    $customers = DB::table('customers')
        ->where('id', $id)
        ->select($selectFields)
        ->first();
    
    // Add profile field if column doesn't exist
    if (empty($columnExists) && $customers) {
        $customers->profile = null;
    }

    // If no student found
    if (!$customers) {
        return redirect()->route('users')->with('error', 'Student not found.');
    }

    // Pass data to view
    return view('studentProfile', compact('customers'));
}




public function deleteStudent($id)
{
    // 1. Find the student/customer first to make sure they exist
    $student = DB::table('customers')->where('id', $id)->first();

    if (!$student) {
        return redirect()->back()->with('error', 'Student not found.');
    }

    try {
        // 2. Start a transaction to ensure both deletes happen, or neither happens
        DB::transaction(function () use ($id) {
            
            // 3. Delete the child records (payments) first
            // This satisfies the Foreign Key constraint
            DB::table('payment')->where('customer_id', $id)->delete();

            // 4. Now delete the parent record (the customer/student)
            DB::table('customers')->where('id', $id)->delete();
        });

        return redirect()->back()->with('success', 'Student and related payments deleted successfully.');

    } catch (\Exception $e) {
        // If something goes wrong, return with the error message
        return redirect()->back()->with('error', 'Deletion failed: ' . $e->getMessage());
    }
}


public function editRoom($id)
{
    $room = DB::table('room')->where('id', $id)->first();

    if (!$room) {
        return redirect()->route('rooms')->with('error', 'Room not found.');
    }

    return view('editRoom', compact('room'));
}




public function updateRoom(Request $request, $id)
{
    $room = DB::table('room')->where('id', $id)->first();

    if (!$room) {
        return redirect()->route('rooms')->with('error', 'Room not found.');
    }

    $request->validate([
        'room_type' => ['required', 'string', 'max:255'],
        'status'    => ['required', 'string', 'max:255'],
        'picture'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
    ]);

    // 1. Prepare Basic Data (Don't include picture yet)
    $updateData = [
        'room_type' => $request->room_type,
        'status'    => $request->status,
    ];

    // 2. Handle Profile Picture Upload
    if ($request->hasFile('picture')) {
        $file = $request->file('picture');
        
        // Ensure folder exists (Force create if missing)
        $uploadPath = public_path('uploads/rooms');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Move the file
        $file->move($uploadPath, $filename);
        
        // Delete old picture if it exists and isn't the default
        // We use public_path() to find the real file location
        if ($room->picture && file_exists(public_path($room->picture))) {
            // Optional: Don't delete if it's a default placeholder
            if (strpos($room->picture, 'default') === false) {
                @unlink(public_path($room->picture));
            }
        }

        // Add the NEW path to the update array
        $updateData['picture'] = 'uploads/rooms/' . $filename;
    }

    // 3. Update Database
    DB::table('room')
        ->where('id', $id)
        ->update($updateData);

    // 4. Log activity
    $adminId = Session::get('id');
    if ($adminId) {
        $this->logActivity($adminId, 'Room Updated', "Updated room: {$room->room_number}", $id, 'room');
    }

    return redirect()->route('rooms')->with('success', 'Room updated successfully!');
}


public function deleteRoom($id)
{
    $room = DB::table('room')->where('id', $id)->first();

    if (!$room) {
        return redirect()->route('rooms')->with('error', 'Room not found.');
    }

    DB::table('room')->where('id', $id)->delete();

    // Log activity
    $adminId = Session::get('id');
    if ($adminId) {
        $this->logActivity($adminId, 'Room Deleted', "Deleted room: {$room->room_number}", $id, 'room');
    }

    return redirect()->route('rooms')->with('success', 'Room deleted successfully.');
}



public function deleteStaff($id)
{
    $staffs = DB::table('staff')->where('id', $id)->first();

    if (!$staffs) {
        return redirect()->route('staffs')->with('error', 'Staff not found.');
    }

    DB::table('staff')->where('id', $id)->delete();

    // Log activity
    $adminId = Session::get('id');
    if ($adminId) {
        $this->logActivity($adminId, 'Staff Deleted', "Deleted staff: {$staffs->Fname} {$staffs->Lname}", $id, 'staff');
    }

    return redirect()->route('staffs')->with('success', 'Staff deleted successfully.');
}



public function rooms(Request $request)
{
    $search = $request->input('search');

    $roomQuery = DB::table('room')
        ->select('id', 'picture', 'room_number', 'room_type', 'status');

    // Only apply search logic if $search is not empty
    if ($search) {
        // ✅ Split the search string into individual words
        $searchTerms = explode(' ', $search);

        // ✅ Loop over each search word
        foreach ($searchTerms as $term) {
            
            // ✅ Group the 'OR' statements for each word
            // This ensures a record must match ALL words (AND logic)
            // but each word can be in ANY of the columns (OR logic)
            $roomQuery->where(function ($query) use ($term) {
                $term = "%{$term}%";
                $query->where('room_number', 'like', $term)
                    ->orWhere('room_type', 'like', $term)
                    ->orWhere('status', 'like', $term);
            });
        }
    }

    // Continue with ordering and pagination
    $room = $roomQuery->orderBy('room_number', 'asc')
                         ->simplePaginate(10); // <-- show 10 users per page

    // Keep the search query in pagination links
    if ($search) {
        $room->appends(['search' => $search]);
    }

    return view('rooms', compact('room', 'search'));
}


public function payments(Request $request)
    {
        $search = $request->input('search');

        // 1. Start with the payment table
        $paymentQuery = DB::table('payment')
            // Join Customers to get Name
            ->leftJoin('customers', 'payment.customer_id', '=', 'customers.id')
            // Join Booking to get Booking details
            ->leftJoin('booking', 'payment.booking_id', '=', 'booking.id') 
            // Join Room (via Booking) to get Room Number
            ->leftJoin('room', 'booking.room_id', '=', 'room.id')
            ->select(
                'payment.id', 
                'payment.payment_option', 
                'payment.amount', 
                'payment.paid_at', 
                'payment.booking_id', // Needed for the "Ref" column
                'customers.Fname', 
                'customers.Lname',
                'room.room_number'    // Needed for the "Room" column
            );

        // 2. Add Search Logic
        if ($search) {
            $searchTerms = explode(' ', $search);

            foreach ($searchTerms as $term) {
                $paymentQuery->where(function ($query) use ($term) {
                    $term = "%{$term}%";
                    $query->where('customers.Fname', 'like', $term)
                        ->orWhere('customers.Lname', 'like', $term)
                        ->orWhere('payment.payment_option', 'like', $term)
                        ->orWhere('payment.booking_id', 'like', $term)
                        ->orWhere('room.room_number', 'like', $term);
                });
            }
        }

        // 3. Order by date (Newest payments first)
        $payments = $paymentQuery->orderBy('payment.paid_at', 'desc')
        ->simplePaginate(10);

        if ($search) {
            $payments->appends(['search' => $search]);
        }

        return view('payment', compact('payments', 'search'));
    }


public function updateProfile(Request $request)
{
    $adminId = Session::get('id');

    if (!$adminId) {
        return redirect()->route('main')->with('error', 'You must log in to update your profile.');
    }

    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admin', 'email')->ignore($adminId)],
        'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'], // Max 5MB
    ]);

    $updateData = [
        'name' => $request->name,
        'email' => $request->email,
    ];

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        
        // Create uploads directory if it doesn't exist
        $uploadPath = public_path('uploads');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);
        
        // Get old profile picture path
        $admin = DB::table('admin')->where('id', $adminId)->first();
        $oldProfilePath = $admin->profile ?? null;
        
        // Delete old profile picture if it exists and is not default
        if ($oldProfilePath && file_exists(public_path($oldProfilePath)) && strpos($oldProfilePath, 'dist/img/') === false) {
            @unlink(public_path($oldProfilePath));
        }
        
        // Update profile path
        $updateData['profile'] = 'uploads/' . $filename;
    }

    DB::table('admin')
        ->where('id', $adminId)
        ->update($updateData);

    // Update session
    Session::put('name', $request->name);
    if (isset($updateData['profile'])) {
        Session::put('profile', $updateData['profile']);
    }

    // Log profile update activity
    $this->logActivity($adminId, 'Profile Updated', 'Updated profile information');

    return redirect()->route('profile')->with('success', 'Profile updated successfully!');
}




public function updateCustomer(Request $request, $id)
{
    $request->validate([
        'Fname' => ['required', 'string', 'max:255'],
        'Lname' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('customers', 'email')->ignore($id)],
        'contact' => ['required', 'string', 'max:15', Rule::unique('customers', 'contact')->ignore($id)],
        'dob' => ['required', 'date'],
        'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'], // Max 5MB
    ]);

    $customer = DB::table('customers')->where('id', $id)->first();

    if (!$customer) {
        return redirect()->route('users')->with('error', 'Customer not found.');
    }

    $updateData = [
        'Fname' => $request->Fname,
        'Lname' => $request->Lname,
        'email' => $request->email,
        'contact' => $request->contact,
        'dob' => $request->dob,
    ];

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        
        // Create uploads directory if it doesn't exist
        $uploadPath = public_path('uploads');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);
        
        // Check if profile column exists in customers table
        $columnExists = DB::select("SHOW COLUMNS FROM customers LIKE 'profile'");
        
        // If column doesn't exist, create it
        if (empty($columnExists)) {
            try {
                DB::statement('ALTER TABLE customers ADD COLUMN profile VARCHAR(255) NULL AFTER dob');
            } catch (\Exception $e) {
                return redirect()->route('studentProfile', $id)->with('error', 'Could not add profile column. Please run: ALTER TABLE customers ADD COLUMN profile VARCHAR(255) NULL');
            }
        }
        
        // Get old profile picture path
        $oldProfilePath = $customer->profile ?? null;
        
        // Delete old profile picture if it exists and is not default
        if ($oldProfilePath && file_exists(public_path($oldProfilePath)) && strpos($oldProfilePath, 'dist/img/') === false) {
            @unlink(public_path($oldProfilePath));
        }
        
        // Update profile path
        $updateData['profile'] = 'uploads/' . $filename;
    }

    DB::table('customers')
        ->where('id', $id)
        ->update($updateData);

    // Log activity
    $adminId = Session::get('id');
    if ($adminId) {
        $this->logActivity($adminId, 'Customer Updated', "Updated customer: {$request->Fname} {$request->Lname}", $id, 'customer');
    }

    return redirect()->route('studentProfile', $id)->with('success', 'Customer information updated successfully!');
}




public function updateStaff(Request $request, $id)
{
    $request->validate([
        'Fname' => ['required', 'string', 'max:255'],
        'Lname' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('staff', 'email')->ignore($id)],
        'contact' => ['required', 'string', 'max:15', Rule::unique('staff', 'contact')->ignore($id)],
        'role' => ['required', 'string', 'max:255'],
    ]);

    $staff = DB::table('staff')->where('id', $id)->first();

    if (!$staff) {
        return redirect()->route('staffs')->with('error', 'Staff not found.');
    }

    DB::table('staff')
        ->where('id', $id)
        ->update([
            'Fname' => $request->Fname,
            'Lname' => $request->Lname,
            'email' => $request->email,
            'contact' => $request->contact,
            'role' => $request->role,
        ]);

    // Log activity
    $adminId = Session::get('id');
    if ($adminId) {
        $this->logActivity($adminId, 'Staff Updated', "Updated staff: {$request->Fname} {$request->Lname}", $id, 'staff');
    }

    return redirect()->route('staffProfile', $id)->with('success', 'Staff information updated successfully!');
}




public function admins(Request $request)
{
    $search = $request->input('search');

    $adminsQuery = DB::table('admin')
        ->select('id', 'name', 'email', 'role', 'profile');

    // Only apply search logic if $search is not empty
    if ($search) {
        // Split the search string into individual words
        $searchTerms = explode(' ', $search);

        // Loop over each search word
        foreach ($searchTerms as $term) {
            // Group the 'OR' statements for each word
            // This ensures a record must match ALL words (AND logic)
            // but each word can be in ANY of the columns (OR logic)
            $adminsQuery->where(function ($query) use ($term) {
                $term = "%{$term}%";
                $query->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('role', 'like', $term);
            });
        }
    }

    // Continue with ordering and pagination
    $admins = $adminsQuery->orderBy('name', 'asc')
                         ->paginate(10); // <-- show 10 admins per page

    // Keep the search query in pagination links
    if ($search) {
        $admins->appends(['search' => $search]);
    }

    return view('admins', compact('admins', 'search'));
}



public function customer_logout(Request $request)
{
    // Clear only customer related sessions to be safe, or flush all
    $request->session()->forget(['customer_id', 'name', 'email']);
    
    // Or keep your flush:
    $request->session()->flush();

    return redirect()->route('main')->with('success', 'You have been logged out successfully.');
}


public function logout(Request $request)
{
    // Log logout activity before clearing session
    $adminId = Session::get('id');
    if ($adminId) {
        $this->logActivity($adminId, 'Logout', 'User logged out');
    }
    
    // Clear all session data
    $request->session()->flush();

    // Redirect to your login page (welcome.blade.php)
    return redirect()->route('main')->with('success', 'You have been logged out successfully.');
}
}
