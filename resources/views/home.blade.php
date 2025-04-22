@extends('layouts.app')

@section('header')
    <header class="header">
        <div class="avatar"></div>
        <nav class="nav-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('dashboard') }}">Class</a>
            <a href="{{ route('about') }}">About</a>
        </nav>
    </header>

    <style>
        .header {
            background-color: #8A4AF3;
            padding: 15px 15px;
            display: flex;
            justify-content: center;
            width: 100%;
            margin: 0;
            position: fixed;
            top: 0;
            left: 0;

        }

        .nav-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .avatar {
            position: fixed;
            top: 10px;
            left: 15px;
            width: 35px;
            height: 35px;
            background-color: #FFFFFF;
            border-radius: 50%;
        }

        .nav-links {
            display: flex;
            gap: 30px;
        }

        .nav-links a {
            color: #FFFFFF;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h1>Welcome to the Home Page</h1>
        <p>This is the home page of the fitness app.</p>
    </div>

    <style>
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #F5E6F5;
            border: 2px solid #0000FF;
            border-radius: 15px;
            font-family: 'Roboto', sans-serif;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #333333;
        }
    </style>
@endsection