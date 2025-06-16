<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{route('/')}}">
            <img src="{{ asset('frontend/assets/images/kl_mobile_final_logo.svg')}}" alt="KL Mobile Events" style="height: 70px; width: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#blog">Blogs</a></li>
            </ul>
            <!-- Shop Button -->
            <div class="ms-3">
                <a href=" " class="navbar-shop-curved">
                    <i class="fas fa-shopping-cart"></i> Shop
                    {{-- <span class="cart-count">3</span> --}} <!-- Optional cart count -->
                </a>
            </div>
        </div>
    </div>
</nav>