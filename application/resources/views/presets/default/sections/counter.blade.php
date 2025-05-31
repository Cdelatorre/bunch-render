@php

    $elements = getContent('counter.element', false, 4);

@endphp

<!-- ==================== Experience Start Here ==================== -->
<section class="experience-area py-60 ">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            @forelse($elements as $item)
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="experience">
                    <div class="experience__count {{counterNumber($item->data_values->counter_digit) == '' ? "position-relative" : '' }}">
                        <h3><span class="odometer" data-count="{{formatNumber(@$item->data_values->counter_digit)}}">00</span><span class="letter">{{counterNumber($item->data_values->counter_digit)}}</span></h3>
                        <h3 class="strocke-text"><span class="odometer" data-count="{{formatNumber(@$item->data_values->counter_digit)}}">00</span>@if(counterNumber($item->data_values->counter_digit) == '') <span class="letter"></span> @endif</h3>
                    </div>
                    <div class="experience__content">
                        <h3 class="title">{{__(@$item->data_values->sub_title)}}</h3>
                    </div>
                </div>
            </div>
            @empty

            @endforelse
        </div>
    </div>
</section>
<!-- ==================== Experience End Here ==================== -->
