@extends('layouts.frontend')

@section('title', 'KL Mobile Events - Premier Event Management in Kuala Lumpur')
@section('meta_description', 'Transform your vision into unforgettable experiences with KL Mobile Events. Specializing in corporate events, weddings, concerts, and exhibitions in Kuala Lumpur.')
@section('meta_keywords', 'event management kuala lumpur, corporate events malaysia, wedding planner KL, concert management, exhibition services, event company malaysia')

@section('og_title', 'KL Mobile Events - Creating Unforgettable Experiences')
@section('og_description', 'From intimate gatherings to grand celebrations, we bring your vision to life with exceptional event management services.')
@section('og_image', asset('frontend/assets/images/kl_mobile_final_logo.jpg'))
@section('og_type', 'website')

@section('twitter_title', 'KL Mobile Events - Premier Event Management')
@section('twitter_description', 'Creating unforgettable experiences in Kuala Lumpur. Corporate events, weddings, concerts & more.')

@section('content')
    @include('home.hero')
    @include('home.what-we-do')
    @include('components.cta')
    @include('home.why-us')
    @include('home.showcase')
    @include('home.about')
    @include('home.clients')
    @include('home.locations')
    @include('home.testimonial')
    @include('home.blog')
    @include('components.contact')
@endsection