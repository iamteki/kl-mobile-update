@if ($teamMembers && $teamMembers->count() > 0)
    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <div class="section-area text-center">
                <span>- MEET THE TEAM -</span>
                <h2 class="fs-two text-white">OUR <span>EXPERT</span> PROFESSIONALS</h2>
                <p class="lead mt-3">The creative minds and technical experts behind your successful events</p>
            </div>

            <!-- Team Grid -->
            <div class="team-grid">
                @foreach ($teamMembers as $member)
                    <div class="team-member">
                        <div class="member-image">
                            <img src="{{ Storage::url($member->image_url) }}"
                                alt="{{ $member->name }}">
                        </div>
                        <div class="member-info">
                            <h4>{{ $member->name }}</h4>
                            <span class="position">{{ $member->position }}</span>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </section>
@endif
