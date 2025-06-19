@extends('layouts.frontend')

@section('title', $eventType->meta_title ?: $eventType->name . ' - KL Mobile Events')
@section('meta_description', $eventType->meta_description ?: Str::limit(strip_tags($eventType->description), 160))
@section('meta_keywords', $eventType->meta_keywords ?: 'event management, ' . strtolower($eventType->name) . ', kuala lumpur events')

@section('og_title', $eventType->meta_title ?: $eventType->name . ' Events by KL Mobile')
@section('og_description', $eventType->meta_description ?: 'Explore our ' . $eventType->name . ' services and portfolio')
@section('og_type', 'website')
@section('og_url', route('events.byType', $eventType->slug))

@section('twitter_title', $eventType->meta_title ?: $eventType->name . ' - KL Mobile Events')
@section('twitter_description', $eventType->meta_description ?: 'Professional ' . $eventType->name . ' services in Kuala Lumpur')

@section('canonical_url', route('events.byType', $eventType->slug))

@section('content')
    @include('events.header')
    @include('components.cta')
    @include('events.showcase')
    @include('components.contact')
@endsection