<!-- Visit Us Section -->
<section class="visit-section">
    <div class="container">
        <div class="section-area text-center">
            <span>- VISIT US -</span>
            <h2 class="fs-two text-white">PLAN YOUR <span>VISIT</span></h2>
        </div>
        
        <div class="row g-4">
            <!-- Left Column - Map -->
            <div class="col-lg-12">
                <div class="map-wrapper h-100">
                    {{-- <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.7385742567!2d101.70858!3d3.162967!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc37d3f4c6b7c3%3A0x7f4cb218b7170b66!2sMenara%20Kuala%20Lumpur!5e0!3m2!1sen!2smy!4v1623456789"
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe> --}}

                    {!! $location->google_map_iframe !!}
                </div>
            </div>
            
           
        </div>
        
    
    </div>
</section>