@extends('layouts.layout')

@section('content')
    <div>
        <button id="home-btn" class="nav-btn" onclick="showSection('home')">Home</button>
        <button id="about-btn" class="nav-btn" onclick="showSection('about')">About</button>
        <button id="contact-btn" class="nav-btn" onclick="showSection('contact')">Contact</button>
    </div>

    <div id="home" class="section">
        <h2>Home Page</h2>
        <p>Welcome to the Home section.</p>
    </div>

    <div id="about" class="section hidden">
        <h2>About Page</h2>
        <p>This is the About section.</p>
    </div>

    <div id="contact" class="section hidden">
        <h2>Contact Page</h2>
        <p>Get in touch via the Contact section.</p>
    </div>