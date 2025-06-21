@extends('layouts.frontend')

@push('styles')
    <!-- Location Page Specific CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/location.css') }}">
@endpush

@section('content')
    @include('location.header')
    @include('location.about')
    @include('location.facilities')
    {{-- @include('location.equipment-gallery') --}}
    @include('location.team')

    @include('location.faq')
       @include('components.cta')
    @include('location.visit')
    @include('components.contact')
@endsection

@push('scripts')
    <!-- Location Page Specific JavaScript -->
    <script src="{{ asset('frontend/assets/js/location.js') }}"></script>
@endpush
