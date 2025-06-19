@extends('layouts.frontend')

@section('title', $event->meta_title ?: $event->title . ' - KL Mobile Events')
@section('meta_description', $event->meta_description ?: Str::limit(strip_tags($event->excerpt ?: $event->description), 160))
@section('meta_keywords', $event->meta_keywords ?: strtolower($event->eventType->name) . ', event management, kuala lumpur')

@section('og_title', $event->meta_title ?: $event->title)
@section('og_description', $event->meta_description ?: $event->excerpt)
@section('og_image', $event->featured_image ? Storage::url($event->featured_image) : asset('frontend/assets/images/kl_mobile_final_logo.jpg'))
@section('og_type', 'article')
@section('og_url', route('event.show', $event->slug))

@section('twitter_card', 'summary_large_image')
@section('twitter_title', $event->title)
@section('twitter_description', Str::limit(strip_tags($event->excerpt ?: $event->description), 200))
@section('twitter_image', $event->featured_image ? Storage::url($event->featured_image) : asset('frontend/assets/images/kl_mobile_final_logo.jpg'))

@section('canonical_url', route('event.show', $event->slug))

@section('content')
    @include('single.header')
    @include('single.video')
    @include('single.description')
    @include('single.gallery')
    @include('components.contact')
@endsection