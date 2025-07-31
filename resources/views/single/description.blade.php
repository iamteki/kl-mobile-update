<!-- Description Section - Enhanced for Long Content -->
<section class="section-padding" style="background: var(--bg-black);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="description-content text-center" data-animscroll="fade-up">
                    @if($event->description)
                        <div class="lead">
                            {!! $event->description !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>