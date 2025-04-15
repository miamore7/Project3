{{-- resources/views/landing.blade.php --}}
@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif; text-align: center;">
    {{-- Text Content --}}
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 36px; margin-bottom: 20px;">Find your right mentor</h1>
        <p style="font-size: 16px; line-height: 1.5; margin-bottom: 20px;">Learn from experts <br> Grow your hobby</p>
        <button style="background-color: #000000; color: #FFFFFFFF; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; margin-bottom: 20px;">Get Started</button>
    </div>
</div>
<div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-top: 30px; text-align: center;">
    <div style="width: 25%; margin-bottom: 20px;">
        <p>34+</p>
        <p>Courses</p>
    </div>
    <div style="width: 25%; margin-bottom: 20px;">
        <p>245K</p>
        <p>Followers And Students</p>
    </div>
    <div style="width: 25%; margin-bottom: 20px;">
        <p>15+</p>
        <p>Profesional Coaches</p>
    </div>
    <div style="width: 25%; margin-bottom: 20px;">
        <p>4.89</p>
        <p>Ratings</p>
    </div>
</div>

{{-- Images Section --}}
<div style="display: flex; justify-content: space-between; margin-bottom: 0; padding-bottom:0;">
    <img src="{{ asset('images/Person1.jpg') }}" alt="Person 1" style="width:35%;">
    <img src="{{ asset('images/Person2.jpg') }}" alt="Person 2" style="width: 35%;">
    <img src="{{ asset('images/Person3.jpg') }}" alt="Person 3" style="width: 35%;">
    <img src="{{ asset('images/Person4.jpg') }}" alt="Person 4" style="width: 35%;">
</div>

@endsection