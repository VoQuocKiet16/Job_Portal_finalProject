@extends('front.layouts.app')

@section('main')
<style>
    
</style>
    <div class="container my-5 py-4">
        <div class="card shadow-lg p-5 text-center" style="border-radius: 10px; background: linear-gradient(135deg, #fff3e0, #f5cbaa);">
            <h3 class="mb-4" style="color: #EE7214; font-weight: 700;">Please Verify Your Email Address</h2>
            <p class="mb-4" style="color: #6b6b6b; font-size: 1.1rem;">Please verify your email to gain full access to your account.</p>
            
            @if (session('success'))
                <div class="alert alert-success" style="font-size: 1rem; font-weight: 500;">
                    {{ session('success') }}
                </div>
            @endif
            
            <form action="{{ route('account.resendVerificationEmail') }}" method="POST" class="mb-3">
                @csrf
                <button type="submit" class="btn btn-lg" style="background-color: #EE7214; border-color: #EE7214; border-radius: 50px; padding: 10px 20px; font-size: 1.2rem; font-weight: 600; color: white;">Resend Verification Email</button>
            </form>
            
            <br>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg" style="border-radius: 50px; padding: 10px 20px; font-size: 1.2rem; font-weight: 600; border-color: #EE7214; color: #EE7214;">Go back to home</a>
        </div>
    </div>
@endsection

