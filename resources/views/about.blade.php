@extends('layouts.navbar')


@section('content')
<div class="about-wrapper">
    <div class="hero-section">
        <div class="hero-text">
            <h1>Welcome to FitZone</h1>
            <p>Your journey to better health, more energy, and total confidence starts here.</p>
        </div>
        <div class="hero-img">
            <img src="/images/header.jpg" alt="Fitness" />
        </div>
    </div>

    <div class="about-card">
        <h2>Our Mission</h2>
        <p>To create a welcoming space for people of all levels to improve their health through fun, effective, and personalized fitness experiences.</p>

        <h2>Our Vision</h2>
        <p>To become your go-to fitness destination – known for inclusivity, community vibes, and results-driven programs.</p>

        <h2>What We Offer</h2>
        <ul>
            <li>Cardio & Strength Classes</li>
            <li>Personal Training</li>
            <li>Nutrition Tips</li>
            <li>Friendly, Certified Trainers</li>
            <li>Online Booking & Scheduling</li>
        </ul>

        <h2>Why Choose Us?</h2>
        <p>We’re not just a gym. We’re a community. With flexible classes, fun trainers, and a supportive vibe, you’ll actually look forward to working out!</p>

        <div class="about-image-gallery">
            <img src="/images/class_one.jpg" alt="Class 1" />
            <img src="/images/class_two.jpg" alt="Class 2" />
            <img src="/images/class_three.jpg" alt="Class 3" />
        </div>

        <h2>Contact Us</h2>
        <p>Email: contact@fitzone.com<br>Phone: (123) 456-7890</p>
    </div>
</div>

<style>
body {
    background-color: #f5eaf3;
    font-family: 'Poppins', sans-serif;
    margin-top: -20px;
}

.about-wrapper {
    max-width: 1100px;
    margin: auto;
    padding: 40px 20px;
}

.hero-section {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 30px;
    margin-bottom: 40px;
}

.hero-text {
    flex: 1;
}

.hero-text h1 {
    font-size: 2.5rem;
    color: #834c71;
    margin-bottom: 15px;
}

.hero-text p {
    font-size: 1.1rem;
    color: #555;
    line-height: 1.6;
}

.hero-img {
    flex: 1;
    text-align: right;
}

.hero-img img {
    max-width: 90%;
    border-radius: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.about-card {
    background-color: #fff;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    color: #333;
}

.about-card h2 {
    color: #a84f61;
    margin-top: 30px;
    margin-bottom: 10px;
}

.about-card ul {
    padding-left: 20px;
    list-style: disc;
}

.about-card ul li {
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.about-image-gallery {
    display: flex;
    gap: 15px;
    margin: 30px 0;
    flex-wrap: wrap;
}

.about-image-gallery img {
    width: 30%;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}
</style>
@endsection
