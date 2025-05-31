@php
    $content = getContent('faq.content', true);
    $contact = getContent('contact_us.content',true);
    if (request()->route()->uri == '/')
    {
        $elements = getContent('faq.element', false, 6);
    }
    else {
        $elements = getContent('faq.element', false, 3);

    }
@endphp


<!-- ==================== Accordion Start Here ==================== -->
<section class="accordion-area py-60 bg-img">
    @if (request()->route()->uri == '/')
        <img src="{{ activeTemplate(true) . '/images/faq-bg-shape.png' }}" alt="faq-bg-shape" class="faq-shape-bg">
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-heading  text-center">
                    <div class="section-heading__border">
                        <span class="one"></span>
                        <span class="two"></span>
                        <span class="three"></span>
                    </div>
                    <h2 class="section-heading__title">{{ __(@$content->data_values->heading) }}</h2>
                    <p class="section-heading__desc">{{ __(@$content->data_values->subheading) }}</p>
                </div>
            </div>
        </div>

        @if (request()->route()->uri == '/')
            <div class="row flex-wrap-reverse gy-4 align-items-center justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion custom--accordion" id="accordionExample">

                        @forelse($elements as $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne{{ $loop->index }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne{{ $loop->index }}" aria-expanded="{{$loop->index == 0 ? 'true' : 'false'}}" aria-controls="collapseOne{{ $loop->index }}">
                                    {{ __($item->data_values->question) }}
                                </button>
                            </h2>
                            <div id="collapseOne{{ $loop->index }}" class="accordion-collapse collapse {{$loop->index == 0 ? 'show' : ''}}" aria-labelledby="headingOne{{$loop->index}}"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @php echo $item->data_values->answer @endphp
                                </div>
                            </div>
                        </div>
                        @empty

                        @endforelse

                    </div>
                </div>
            </div>
        @else
            <div class="row flex-wrap-reverse gy-4">

                <div class="col-lg-5">
                    <div class="about-thumb-faq">
                        <div class="about-thumb__inner">
                            <img class="img-2" src="{{getImage(getFilePath('faq').'/'. @$content->data_values->image)}}" alt="image">

                            <div class="about-img-contact animate-x-axis">
                                <div class="icon-wrapper">
                                    <span class="dotted-radius"></span>
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="41" height="41"
                                            viewBox="0 0 41 41" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M24.6368 37.2549C24.6368 35.8378 23.488 34.689 22.071 34.689H18.929C18.2485 34.689 17.5959 34.9594 17.1147 35.4406C16.6335 35.9217 16.3632 36.5744 16.3632 37.2549C16.3632 38.6719 17.512 39.8207 18.929 39.8207H22.071C23.488 39.8207 24.6368 38.6719 24.6368 37.2549ZM5.39414 30.6386C5.82272 30.6713 6.34123 30.6902 6.86205 30.6597C7.13953 32.0668 7.82884 33.3719 8.85776 34.4009C10.2237 35.7668 12.0763 36.5342 14.0081 36.5342H14.9871C14.9439 36.7704 14.9218 37.0115 14.9218 37.2549C14.9218 37.501 14.9439 37.7419 14.9865 37.9756H14.0081C11.694 37.9756 9.47476 37.0564 7.83853 35.4201C6.53317 34.1147 5.68411 32.4383 5.39414 30.6386ZM4.66095 29.1049C3.52296 28.913 2.464 28.372 1.63736 27.5453C0.588975 26.4969 0 25.0749 0 23.5923V20.1855C0 18.7029 0.588975 17.2809 1.63736 16.2325C2.68574 15.1842 4.10769 14.5951 5.59033 14.5951H5.96246C6.55728 7.08729 12.8388 1.17969 20.5 1.17969C28.1612 1.17969 34.4427 7.08729 35.0375 14.5951H35.4097C36.8923 14.5951 38.3143 15.1842 39.3626 16.2325C40.411 17.2809 41 18.7029 41 20.1855V23.5923C41 25.0749 40.411 26.4969 39.3626 27.5453C38.3143 28.5937 36.8923 29.1827 35.4097 29.1827H33.76C33.0758 29.1827 32.5212 28.628 32.5212 27.9439V15.7634C32.5212 9.12424 27.1391 3.74219 20.5 3.74219C13.8609 3.74219 8.47883 9.12424 8.47883 15.7634V27.9439C8.47883 28.4269 8.20232 28.8455 7.79889 29.0498C6.68836 29.4351 4.96613 29.1563 4.66095 29.1049Z" />
                                        </svg>
                                    </div>
                                </div>
                                <p>@lang('Get in touch with us')</p>
                                <h4><a href="tel:{{__(@$contact->data_values->contact_number)}}">{{__(@$contact->data_values->contact_number)}}</a></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="about-right-content">
                        <div class="section-heading left-content">
                            <div class="section-heading__border">
                                <span class="one"></span>
                                <span class="two"></span>
                                <span class="three"></span>
                            </div>
                            <h2 class="section-heading__title">{{ __(@$content->data_values->heading) }}</h2>
                            <p class="section-heading__desc">{{ __(@$content->data_values->subheading) }}</p>
                        </div>

                        <div class="accordion custom--accordion" id="accordionExample">
                            @forelse($elements as $item)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne{{$loop->index}}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne{{ $loop->index }}" aria-expanded="{{$loop->index == 0 ? 'true' : 'false'}}" aria-controls="collapseOne{{ $loop->index }}">
                                        {{ __($item->data_values->question) }}
                                    </button>
                                </h2>
                                <div id="collapseOne{{ $loop->index }}" class="accordion-collapse collapse {{$loop->index == 0 ? 'show' : ''}}" aria-labelledby="headingOne{{$loop->index}}"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        @php echo trans($item->data_values->answer) @endphp
                                    </div>
                                </div>
                            </div>
                            @empty

                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        @endif

    </div>
</section>
<!-- ==================== Accordion End Here ==================== -->
