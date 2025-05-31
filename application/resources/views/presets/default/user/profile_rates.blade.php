@extends($activeTemplate.'layouts.master')
@section('content')



<form method="post" enctype="multipart/form-data">
    @csrf
    <div class="row gy-4 justify-content-center profile-rates">
        <div class="col-md-12 col-sm-12 mt-4">
            <div class="rates-input-section">
                <div class="row mb-3 gy-3">
                    <div class="col-lg-11 col-mb-10">
                        <label class="w-100 font-weight-bold">@lang('Rates')</label>
                    </div>
                </div>

                <div class="row extraRates">
                    @php
                        $rates = json_decode($product->rates ?? '[]', true);
                    @endphp
                    @forelse($rates as $rate)
                    <div class="data-extra-rates mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <div>
                                <i class="las la-edit"></i>
                            </div>
                            <div>
                                <div class="form-group">
                                    <input class="form-control custom-form-field input-title" name="rates[{{$loop->index}}][title]" type="text" required placeholder="@lang('Title')"  value="{{$rate['title']}}">
                                </div>
                                <div class="form-group">
                                    <input class="form-control custom-form-field input-description" name="rates[{{$loop->index}}][description]" type="text" required placeholder="@lang('Description')"  value="{{$rate['description']}}">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="form-group">
                                <input class="form-control custom-form-field input-price" name="rates[{{$loop->index}}][price]" type="number" required placeholder="50"  value="{{$rate['price']}}">
                            </div>
                            <button type="button" class="btn btn--default remove_extra_rates"><i class="la la-times"></i></button>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>

                <div class="row mt-4 justify-content-center">
                    <button type="button" class="btn btn--default btn-block extra_rates">
                        <i class="fa fa-plus"></i> @lang('Add more rates')
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 mt-4">
            <div class="rates-input-section">
                <div class="row mb-3 gy-3">
                    <div class="col-lg-11 col-md-10">
                        <label class="w-100 font-weight-bold">@lang('Your call to action')</label>
                    </div>
                </div>

                <div class="row cta-section">
                    <div class="mb-2">
                        <input type="radio" id="free-visit" name="call_to_action" value="0" {{ (int) $product->call_to_action === 0 ? 'checked' : '' }}>
                        <label for="free-visit">@lang('Request a free visit')</label>
                    </div>
                    <div class="mb-2">
                        <input type="radio" id="see-the-website" name="call_to_action" value="1"  {{ (int) $product->call_to_action === 1 ? 'checked' : '' }}>
                        <label for="see-the-website">@lang('See the website')</label>
                    </div>
                    <div class="mb-2">
                        <input type="radio" id="see-instagram" name="call_to_action" value="2"  {{ (int) $product->call_to_action === 2 ? 'checked' : '' }}>
                        <label for="see-instagram">@lang('See the instagram')</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 mt-4">
            <button type="submit" class="btn btn--base border-none">
                @lang('Save Changes')
            </button>
        </div>
    </div>
</form>
@endsection

@push('script')
    <script>
        "use strict";

        $('.extra_rates').on('click', function () {
            var index = $('.data-extra-rates').length;
            var html = `
                <div class="data-extra-rates mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <div>
                            <i class="las la-edit"></i>
                        </div>
                        <div>
                            <div class="form-group">
                                <input class="form-control custom-form-field input-title" name="rates[${index}][title]" type="text" required placeholder="@lang('Title')">
                            </div>
                            <div class="form-group">
                                <input class="form-control custom-form-field input-description" name="rates[${index}][description]" type="text" required placeholder="@lang('Description')">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="form-group">
                            <input class="form-control custom-form-field input-price" name="rates[${index}][price]" type="number" required placeholder="50">
                        </div>
                        <button type="button" class="btn btn--default remove_extra_rates"><i class="la la-times"></i></button>
                    </div>
                </div>
                `;
            $('.extraRates').append(html);
            $(`[name="rates[${index}][title]"]`).focus();
        });

        $(document).on('click', '.remove_extra_rates', function () {
            $(this).closest('.data-extra-rates').remove();
        });
    </script>
@endpush