<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

// 1. PUBLIC ROUTES
Route::get('/', [MainController::class, 'main'])->name('main');
Route::get('/index', function () { return view('welcome'); });
Route::get('/register', [MainController::class, 'register'])->name('register');
Route::post('/save-user', [MainController::class, 'save_user'])->name('save_user');
Route::post('/authenticate', [MainController::class, 'auth_user'])->name('auth_user');

// Guest Booking
Route::get('/guestbooking', [MainController::class, 'guestbooking'])->name('guestbooking');
Route::post('/guest-book-room', [MainController::class, 'guest_book_room'])->name('guest_book_room');


// 2. ADMIN PROTECTED ROUTES
Route::middleware('admin.auth')->group(function () {
    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [MainController::class, 'profile'])->name('profile');
    Route::put('/profile', [MainController::class, 'updateProfile'])->name('updateProfile');
    
    // User Management
    Route::get('/users', [MainController::class, 'users'])->name('users');
    Route::get('/students/{id}', [MainController::class, 'studentProfile'])->name('studentProfile');
    Route::put('/customers/{id}', [MainController::class, 'updateCustomer'])->name('updateCustomer');
    Route::delete('/students/{id}', [MainController::class, 'deleteStudent'])->name('deleteStudent');
    Route::get('/admins', [MainController::class, 'admins'])->name('admins');
    Route::delete('/staffs/{id}', [MainController::class, 'deleteStaff'])->name('deleteStaff');

    // Room Management
    Route::get('/rooms', [MainController::class, 'rooms'])->name('rooms');
    Route::get('/addroom', [MainController::class, 'addroom'])->name('addroom');
    Route::post('/saveroom', [MainController::class, 'save_room'])->name('save_room');
    Route::get('/rooms/{id}/edit', [MainController::class, 'editRoom'])->name('editRoom');
    Route::put('/rooms/{id}', [MainController::class, 'updateRoom'])->name('updateRoom');
    Route::delete('/rooms/{id}', [MainController::class, 'deleteRoom'])->name('deleteRoom');

    // Booking & Payment Management
    Route::get('/booked-rooms', [MainController::class, 'bookedRooms'])->name('bookedRooms');
    Route::get('/bookings/{id}', [MainController::class, 'viewBooking'])->name('viewBooking');
    Route::post('/bookings/{id}/status', [MainController::class, 'updateBookingStatus'])->name('bookings.updateStatus');
    Route::post('/bookings/{id}/payment', [MainController::class, 'storeBookingPayment'])->name('bookings.storePayment');
    Route::get('/payments', [MainController::class, 'payments'])->name('payments');

    Route::post('/logout', [MainController::class, 'logout'])->name('logout');
});



// 3. CUSTOMER PROTECTED ROUTES
Route::middleware(['customer.auth'])->group(function () {
    Route::get('/customer-dashboard', [MainController::class, 'customerDashboard'])->name('customerDashboard');
    Route::get('/member-booking', [MainController::class, 'memberBooking'])->name('memberBooking');
    Route::post('/member-book-room', [MainController::class, 'member_book_room'])->name('member_book_room');
    
    // Member Booking Management
    Route::get('/my-bookings/{id}', [MainController::class, 'customerViewBooking'])->name('customer.viewBooking');
    Route::post('/my-bookings/{id}/cancel', [MainController::class, 'customerCancelBooking'])->name('customer.cancelBooking');
    
    // Checkout (Protected for customers)
    Route::get('/checkout/{id}', [MainController::class, 'showCheckout'])->name('showCheckout');
    Route::post('/checkout-booking/{id}', [MainController::class, 'checkoutBooking'])->name('checkoutBooking');

    Route::post('/customer-logout', [MainController::class, 'customer_logout'])->name('customer.logout');
});