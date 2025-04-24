@extends('layouts.app')

@section('header')
<header class="header">
    <div class="avatar"></div>
    <nav class="nav-links">
        <a href="{{ route('landingpage') }}">Home</a>
        <a href="{{ route('dashboard') }}">Class</a>
        <a href="{{ route('about') }}" class="active">About</a>
    </nav>
</header>

<style>
.header {
    background-color: #834c71;
    padding: 15px;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin: 0;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 10;
}

.avatar {
    position: fixed;
    top: 10px;
    left: 15px;
    width: 35px;
    height: 35px;
    background-color: #fff;
    border-radius: 50%;
}

.nav-links {
    display: flex;
    gap: 30px;
}

.nav-links a {
    color: #fff;
    font-size: 18px;
    font-weight: bold;
    text-decoration: none;
}

.nav-links a.active,
.nav-links a:hover {
    text-decoration: underline;
}
</style>
@endsection

@section('content')
<div class="container">
    <h1>About Us</h1>
    <p>This is the about page of the fitness app. Learn more about our classes and schedules.</p>
</div>

<style>
body {
    background-color: #f5eaf3;
    margin: 0;
    padding-top: 80px; /* To offset fixed header */
    font-family: 'Poppins', sans-serif;
}

.container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 30px;
    background-color: #fff;
    border: 2px solid #d87384;
    border-radius: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

h1 {
    font-size: 28px;
    font-weight: bold;
    color: #834c71;
    margin-bottom: 20px;
}

p {
    font-size: 16px;
    color: #333;
    line-height: 1.6;
}
</style>
@endsection
