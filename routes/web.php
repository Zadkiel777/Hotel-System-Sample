<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LogoutController;


/*
|--------------------------------------------------------------------------
| Web Routes
|---------------------------------------------*-
-----------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/index', function () {
    return view('welcome');
});

Route::get('/', [MainController::class, 'main'])->name('main');
Route::get('/register', [MainController::class, 'register'])->name('register');
Route::get('/customer-dashboard', [MainController::class, 'customerDashboard'])->name('customerDashboard');
Route::post('/save-user', [MainController::class, 'save_user'])->name('save_user');
Route::post('/authenticate', [MainController::class, 'auth_user'])->name('auth_user');
Route::get('/addroom', [MainController::class, 'addroom'])->name('addroom');
Route::post('/saveroom', [MainController::class, 'save_room'])->name('save_room');
Route::get('/addstaff', [MainController::class, 'addstaff'])->name('addstaff');
Route::post('/savestaff', [MainController::class, 'save_staff'])->name('save_staff');
Route::get('/payments', [MainController::class, 'payments'])->name('payments');
Route::get('/booked-rooms', [App\Http\Controllers\MainController::class, 'bookedRooms'])->name('bookedRooms');
Route::get('/guestbooking', [MainController::class, 'guestbooking'])->name('guestbooking');
Route::post('/guest-book-room', [MainController::class, 'guest_book_room'])->name('guest_book_room');

// Member-only booking form & action
Route::get('/member-booking', [MainController::class, 'memberBooking'])->name('memberBooking');
Route::post('/member-book-room', [MainController::class, 'member_book_room'])->name('member_book_room');

// UPDATED: Renamed the route to 'dashboard' for consistency and clarity
Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');

// NEW ROUTE: Added the named route for the Profile page
Route::get('/profile', [MainController::class, 'profile'])->name('profile');
Route::put('/profile', [MainController::class, 'updateProfile'])->name('updateProfile');

// NEW ROUTE: Added the named route for the List of Users page
Route::get('/users', [MainController::class, 'users'])->name('users');

Route::get('/admins', [MainController::class, 'admins'])->name('admins');

Route::post('/logout', [MainController::class, 'logout'])->name('logout');

Route::get('/students/{id}', [MainController::class, 'studentProfile'])->name('studentProfile');
Route::put('/customers/{id}', [MainController::class, 'updateCustomer'])->name('updateCustomer');

Route::delete('/students/{id}', [MainController::class, 'deleteStudent'])->name('deleteStudent');

Route::get('/rooms', [MainController::class, 'rooms'])->name('rooms');

Route::get('/staffs', [MainController::class, 'staffs'])->name('staffs');

Route::get('/staffs/{id}', [MainController::class, 'staffProfile'])->name('staffProfile');
Route::put('/staffs/{id}', [MainController::class, 'updateStaff'])->name('updateStaff');

Route::get('/rooms/{id}/edit', [MainController::class, 'editRoom'])->name('editRoom');
Route::put('/rooms/{id}', [MainController::class, 'updateRoom'])->name('updateRoom');
Route::delete('/rooms/{id}', [MainController::class, 'deleteRoom'])->name('deleteRoom');

Route::get('/bookings/{id}', [MainController::class, 'viewBooking'])->name('viewBooking');

// Booking lifecycle & payments
Route::post('/bookings/{id}/status', [MainController::class, 'updateBookingStatus'])->name('bookings.updateStatus');
Route::post('/bookings/{id}/payment', [MainController::class, 'storeBookingPayment'])->name('bookings.storePayment');

// Customer booking details (member-facing)
Route::get('/my-bookings/{id}', [MainController::class, 'customerViewBooking'])->name('customer.viewBooking');
Route::post('/my-bookings/{id}/cancel', [MainController::class, 'customerCancelBooking'])->name('customer.cancelBooking');

Route::delete('/staffs/{id}', [MainController::class, 'deleteStaff'])->name('deleteStaff');
