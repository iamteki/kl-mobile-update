<!-- Contact Form -->
<section id="contact" class="contact-section">
    <div class="container">
        <div class="section-area text-center mb-5">
            <span>- GET IN TOUCH -</span>
            <h2 class="fs-two text-white">LET'S CREATE <span>SOMETHING AMAZING</span></h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   name="name" 
                                   placeholder="Your Name" 
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   placeholder="Your Email" 
                                   value="{{ old('email') }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <input type="tel" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   name="phone" 
                                   placeholder="Phone Number"
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <select class="form-control @error('service') is-invalid @enderror" 
                                    name="service">
                                <option value="">Select Service</option>
                                @foreach($eventTypes as $eventType)
                                    <option value="{{ $eventType->id }}" 
                                            {{ old('service') == $eventType->id ? 'selected' : '' }}>
                                        {{ $eventType->name }}
                                    </option>
                                @endforeach
                                <option value="other" {{ old('service') == 'other' ? 'selected' : '' }}>
                                    Other Event
                                </option>
                            </select>
                            @error('service')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      name="message" 
                                      rows="5"
                                      placeholder="Tell us about your event..."
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </div>
                    </div>
                </form>
                
                @if(session('success'))
                    <div class="alert alert-success mt-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif
                
                @if($errors->has('error'))
                    <div class="alert alert-danger mt-4" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>