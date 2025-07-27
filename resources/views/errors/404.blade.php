@extends('layouts.frontend')

@section('title', 'Page Not Found - KL Mobile Events')
@section('meta_description', 'The page you are looking for could not be found. Explore our event management services and get back to planning your perfect event.')

@push('styles')
<style>
    .error-page-section {
        min-height: 100vh;
        background: var(--bg-black);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        padding: 200px 0;
    }

    .error-container {
        position: relative;
        z-index: 10;
        text-align: center;
        width: 100%;
        padding: 0 20px;
    }

    .error-404 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(8rem, 15vw, 12rem);
        font-weight: 500;
        line-height: 0.8;
        background: var(--gradient-purple);
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1rem;
        animation: gradientShift 3s ease infinite;
    }

    .error-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(2rem, 4vw, 3.5rem);
        font-weight: 500;
        margin-bottom: 1.5rem;
        color: var(--off-white);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .error-subtitle {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        font-size: 1.1rem;
        color: var(--light-gray);
        margin-bottom: 2.5rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .error-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 3rem;
    }

    .btn-primary-custom {
        background: var(--gradient-purple);
        border: none;
        padding: 14px 35px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        color: var(--pure-white);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 5px 25px rgba(147, 51, 234, 0.3);
    }

    .btn-primary-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 40px rgba(147, 51, 234, 0.5);
        color: var(--pure-white);
    }

    .btn-secondary-custom {
        background: transparent;
        border: 2px solid var(--primary-purple);
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        color: var(--off-white);
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-secondary-custom:hover {
        background: rgba(147, 51, 234, 0.1);
        transform: translateY(-3px);
        color: var(--secondary-purple);
        border-color: var(--secondary-purple);
    }

    .logo-404 {
        height: 80px;
        width: auto;
        margin-bottom: 2rem;
        filter: drop-shadow(0 0 20px rgba(147, 51, 234, 0.3));
    }

    /* Floating particles */
    .error-particles {
        position: absolute;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    .error-particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: var(--primary-purple);
        border-radius: 50%;
        opacity: 0.3;
        animation: floatParticle 10s infinite ease-in-out;
    }

    @media (max-width: 768px) {
        .error-page-section {
            padding: 60px 0;
        }
        
        .error-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .btn-primary-custom,
        .btn-secondary-custom {
            width: 100%;
            max-width: 300px;
            justify-content: center;
        }
        
        .error-subtitle {
            font-size: 1rem;
            padding: 0 15px;
        }
    }
</style>
@endpush

@section('content')
<section class="error-page-section">
    <!-- Floating particles -->
    <div class="error-particles">
        <div class="error-particle" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
        <div class="error-particle" style="top: 60%; right: 15%; animation-delay: 2s;"></div>
        <div class="error-particle" style="top: 80%; left: 70%; animation-delay: 4s;"></div>
        <div class="error-particle" style="top: 10%; right: 30%; animation-delay: 1s;"></div>
    </div>

    <div class="container">
        <div class="error-container">
            <!-- Logo -->
          
            <!-- 404 Number -->
            <div class="error-404">404</div>
            
            <!-- Error Title -->
            <h1 class="error-title">Page Not Found</h1>
            
            <!-- Error Description -->
            <p class="error-subtitle">
                The page you're looking for seems to have vanished like a magic trick at one of our events! 
                Don't worry though - we'll help you get back to the action.
            </p>
            
            <!-- Action Buttons -->
            <div class="error-buttons">
                <a href="{{ url('/') }}" class="btn-primary-custom">
                    <i class="fas fa-home"></i> Return Home
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Add fade-in animation on page load
    document.addEventListener('DOMContentLoaded', function() {
        const errorContainer = document.querySelector('.error-container');
        errorContainer.style.opacity = '0';
        errorContainer.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            errorContainer.style.transition = 'all 0.8s ease';
            errorContainer.style.opacity = '1';
            errorContainer.style.transform = 'translateY(0)';
        }, 200);
    });
</script>
@endpush