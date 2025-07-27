<!-- Contact Form -->
<section id="contact" class="contact-section">
    <div class="container" data-animscroll="fade-up">
        <div class="section-area text-center mb-5">
            <span>- GET IN TOUCH -</span>
            <h2  class="fs-two text-white">LET'S CREATE <span>SOMETHING AMAZING</span></h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form id="contactForm" method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" 
                                   class="form-control" 
                                   id="name"
                                   name="name" 
                                   placeholder="Your Name" 
                                   value="{{ old('name') }}" 
                                   required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <input type="email" 
                                   class="form-control" 
                                   id="email"
                                   name="email" 
                                   placeholder="Your Email" 
                                   value="{{ old('email') }}" 
                                   required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <input type="tel" 
                                   class="form-control" 
                                   id="phone"
                                   name="phone" 
                                   placeholder="Phone Number"
                                   value="{{ old('phone') }}">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" 
                                    id="service"
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
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12">
                            <textarea class="form-control" 
                                      id="message"
                                      name="message" 
                                      rows="5"
                                      placeholder="Tell us about your event..."
                                      required>{{ old('message') }}</textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary px-5" id="submitBtn">
                                <i class="fas fa-paper-plane me-2"></i>
                                <span class="btn-text">Send Message</span>
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Success/Error Messages -->
                <div id="formMessages" class="mt-4" style="display: none;">
                    <div class="alert" role="alert">
                        <i class="alert-icon me-2"></i>
                        <span class="alert-message"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>