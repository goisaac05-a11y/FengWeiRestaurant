<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    // ==========================================
    // Show Contact Page
    // ==========================================
    public function index()
    {
        return view('contact.index');
    }

    // ==========================================
    // Submit Contact Form
    // ==========================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'order_id'   => 'nullable|string|max:255',
            'query_type' => 'required|string|in:order_status,food_quality,refund_request,menu_inquiry,other',
            'message'    => 'required|string|min:10|max:2000',
        ], [
            'name.required'       => 'Please fill in your name.',
            'email.required'      => 'Please enter your email address.',
            'email.email'         => 'Please enter a valid email address.',
            'query_type.required' => 'Please select a query type.',
            'query_type.in'       => 'Invalid query type selected.',
            'message.required'    => 'Message is required.',
            'message.min'         => 'Message must be at least 10 characters.',
        ]);

        ContactMessage::create([
            'user_id'    => Auth::check() ? Auth::id() : null,
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'order_id'   => $validated['order_id'] ?? null,
            'query_type' => $validated['query_type'],
            'message'    => $validated['message'],
        ]);

        return back()->with('success', "Thank you for your message! We'll get back to you soon.");
    }
}