@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="row gy-4 mb-none-15">
                            <div class="col-sm-12 col-xl-3 col-lg-6 mb-15">
                                <div class="form-group">
                                    <label class="w-100 font-weight-bold">@lang('Title')</label>
                                    <input type="text" class="form-control" placeholder="@lang('Product Title')" name="title" value="{{ old('title') }}" required/>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-3 col-lg-6 mb-15">
                                <div class="form-group">
                                    <label class="w-100 font-weight-bold">@lang('Email')</label>
                                    <input type="email" class="form-control" placeholder="@lang('Product Title')" name="email" value="{{ old('email') }}" required/>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-3 col-lg-6 mb-15">
                                <div class="form-group">
                                    <label class="w-100 font-weight-bold">@lang('Activity')</label>
                                    <select name="categories[]" class="form-control categories-select" data-placeholder="Begin typing a name to filter..." multiple="multiple" required>
                                        <option value="">@lang('Select One')</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-3 col-lg-6 mb-15">
                                <div class="form-group">
                                    <label class="w-100 font-weight-bold">@lang('Service')</label>
                                    <select name="services[]" class="form-control services-select" data-placeholder="Begin typing a name to filter..." multiple="multiple" required>
                                        @foreach ($rootServices as $services)
                                        <optgroup label="{{ $services->name }}">
                                            @foreach ($services->children as $service)
                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-3 col-lg-6 mb-15">
                                <div class="form-group">
                                    <label class="w-100 font-weight-bold">@lang('Phone')</label>
                                    <input type="text" class="form-control" placeholder="@lang('Phone')" name="phone" value="{{ old('phone') }}" />
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-3 col-lg-6 mb-15">
                                <div class="input-group">
                                    <label class="w-100 font-weight-bold">@lang('Call To Action') <span class="text-danger">*</span></label>
                                    <select name="call_to_action" class="form-control" required>
                                        <option value="0">@lang('Request a free visit')</option>
                                        <option value="1">@lang('See the website')</option>
                                        <option value="2">@lang('See the instagram')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-3 col-lg-6 mb-15">
                                <div class="form-group">
                                    <label class="w-100 font-weight-bold">@lang('Website')</label>
                                    <input type="text" class="form-control" placeholder="@lang('Website')" name="website" value="{{ old('website') }}" />
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-3 col-lg-6 mb-15">
                                <div class="form-group">
                                    <label class="w-100 font-weight-bold">@lang('Social')</label>
                                    <input type="text" class="form-control" placeholder="@lang('Social')" name="social_link" value="{{ old('social_link') }}" />
                                </div>
                            </div>
                            {{-- <div class="col-sm-12 col-xl-3 col-lg-6 mb-15">
                                <label class="w-100 font-weight-bold">@lang('Price') <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" step="any" placeholder="@lang('Ex'). 5.50" name="price" value="{{ old('price') }}" required/>
                            </div> --}}
                            <div class="col-sm-12 col-xl-3 col-lg-6 mb-15">
                                <div class="input-group">
                                    <label class="w-100 font-weight-bold">@lang('Schedule') <span class="text-danger">*</span></label>
                                    <select name="schedule" class="form-control" required>
                                        <option value="1">@lang('Yes')</option>
                                        <option value="0">@lang('No')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-3 col-lg-6 mb-15 started_at">
                                <div class="form-group">
                                    <label class="w-100 font-weight-bold">@lang('Started Time')</label>
                                    <input type="text" name="started_at" placeholder="@lang('Select Date & Time')" id="startDateTime" data-position="bottom left" class="form-control border-radius-5" value="{{ old('started_at') }}" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-3 col-lg-6 mb-15">
                                <div class="form-group">
                                    <label class="w-100 font-weight-bold">@lang('Expired Time')</label>
                                    <input type="text" name="expired_at" placeholder="@lang('Select Date & Time')" id="endDateTime" data-position="bottom left" class="form-control border-radius-5" value="{{ old('expired_at') }}" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="col-12 d-none">
                                <div class="form-group">
                                    <label class="font-weight-bold">@lang('Short Description')</label>
                                    <textarea rows="4" class="form-control border-radius-5" name="short_description">{{ old('short_description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mt-3">
                                    <label class="font-weight-bold">@lang('Description')</label>
                                    <textarea rows="8" class="form-control trumEdit" name="description">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row gy-3">
                            <div class="col-lg-12">
                                <div class="address-input-section">
                                    <div class="row mb-3 gy-3">
                                        <div class="col-lg-11 col-mb-10">
                                            <h5 class="font-weight-bold">@lang('Address')</h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 mb-15">
                                            <div class="form-group">
                                                <label for="autocomplete" class="form--label">@lang('Find Your Location')</label>
                                                <input type="text" name="autocomplete" class="form-control" id="autocomplete" placeholder="@lang('Find Your Location')">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-xl-4 col-lg-6 mb-15">
                                            <div class="form-group">
                                                <label class="w-100 font-weight-bold">@lang('Street Name')</label>
                                                <input type="text" name="address[street_name]" placeholder="@lang('Street Name')" data-position="bottom left" class="form-control border-radius-5" value="{{ old('address["street_name"]') }}" autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xl-2 col-lg-6 mb-15">
                                            <div class="form-group">
                                                <label class="w-100 font-weight-bold">@lang('Street Number')</label>
                                                <input type="text" name="address[street_number]" placeholder="@lang('Street Number')" data-position="bottom left" class="form-control border-radius-5" value="{{ old('address["street_number"]') }}" autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xl-2 col-lg-6 mb-15">
                                            <div class="form-group">
                                                <label class="w-100 font-weight-bold">@lang('Zip Code')</label>
                                                <input type="text" name="address[zip_code]" placeholder="@lang('Zip Code')" data-position="bottom left" class="form-control border-radius-5" value="{{ old('address["zip_code"]') }}" autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xl-2 col-lg-6 mb-15">
                                            <div class="form-group">
                                                <label class="w-100 font-weight-bold">@lang('Locality')</label>
                                                <input type="text" name="address[locality]" placeholder="@lang('Locality')" data-position="bottom left" class="form-control border-radius-5" value="{{ old('address["locality"]') }}" autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xl-2 col-lg-6 mb-15">
                                            <div class="form-group">
                                                <label class="w-100 font-weight-bold">@lang('Province')</label>
                                                <input type="text" name="address[province]" placeholder="@lang('Province')" data-position="bottom left" class="form-control border-radius-5" value="{{ old('address["province"]') }}" autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <input class="d-none" type="text" name="latitude" value="">
                                        <input class="d-none" type="text" name="longitude" value="">
                                        <input class="d-none" type="text" name="formatted_address" value="">
                                        <input class="d-none" type="text" name="place_id" value="">
                                        <input class="d-none" type="text" name="google_rating" value="">
                                        <input class="d-none" type="text" name="google_review_count" value="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row gy-3">
                            <div class="col-lg-12">
                                <div class="billing-input-section">
                                    <div class="row mb-3 gy-3">
                                        <div class="col-lg-11 col-mb-10">
                                            <h5 class="font-weight-bold">@lang('Billing Address')</h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 mb-15">
                                            <div class="form-group">
                                                <label for="billing_autocomplete" class="form--label">@lang('Find Your Location')</label>
                                                <input type="text" name="billing_autocomplete" class="form-control" id="billing_autocomplete" placeholder="@lang('Find Your Location')">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-xl-4 col-lg-6 mb-15">
                                            <div class="form-group">
                                                <label class="w-100 font-weight-bold">@lang('Street Name')</label>
                                                <input type="text" name="billing_address[street_name]" placeholder="@lang('Street Name')" data-position="bottom left" class="form-control border-radius-5" value="{{ old('billing_address["street_name"]') }}" autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xl-2 col-lg-6 mb-15">
                                            <div class="form-group">
                                                <label class="w-100 font-weight-bold">@lang('Street Number')</label>
                                                <input type="text" name="billing_address[street_number]" placeholder="@lang('Street Number')" data-position="bottom left" class="form-control border-radius-5" value="{{ old('billing_address["street_number"]') }}" autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xl-2 col-lg-6 mb-15">
                                            <div class="form-group">
                                                <label class="w-100 font-weight-bold">@lang('Zip Code')</label>
                                                <input type="text" name="billing_address[zip_code]" placeholder="@lang('Zip Code')" data-position="bottom left" class="form-control border-radius-5" value="{{ old('billing_address["zip_code"]') }}" autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xl-2 col-lg-6 mb-15">
                                            <div class="form-group">
                                                <label class="w-100 font-weight-bold">@lang('Locality')</label>
                                                <input type="text" name="billing_address[locality]" placeholder="@lang('Locality')" data-position="bottom left" class="form-control border-radius-5" value="{{ old('billing_address["locality"]') }}" autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xl-2 col-lg-6 mb-15">
                                            <div class="form-group">
                                                <label class="w-100 font-weight-bold">@lang('Province')</label>
                                                <input type="text" name="billing_address[province]" placeholder="@lang('Province')" data-position="bottom left" class="form-control border-radius-5" value="{{ old('billing_address["province"]') }}" autocomplete="off" required/>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row gy-3">
                            <div class="col-lg-12">
                                <div class="schedules-input-section">
                                    <div class="row mb-3 gy-3">
                                        <div class="col-lg-11 col-mb-10">
                                            <h5 class="font-weight-bold">@lang('Schedules')</h5>
                                        </div>
                                    </div>
                                    @php
                                        $schedules = [[
                                            "name" => "Monday - Friday",
                                            "start_time" => "09:00",
                                            "end_time" => "17:00",
                                            "status" => "opened",
                                        ],[
                                            "name" => "Saturday",
                                            "start_time" => "09:00",
                                            "end_time" => "17:00",
                                            "status" => "opened",
                                        ],[
                                            "name" => "Sunday",
                                            "start_time" => "09:00",
                                            "end_time" => "17:00",
                                            "status" => "opened",
                                        ]];
                                    @endphp
                                    <div class="row extraSchedules">
                                        @forelse($schedules as $schedule)
                                        <div class="data-extra-schedules">
                                            <div class="row">
                                                <div class="col-12 col-md-3 mb-2">
                                                    <div class="form-group">
                                                        <input class="form-control" name="schedules[{{$loop->index}}][name]" type="text" required readonly border-none placeholder="@lang('Name')"  value="{{$schedule['name']}}">
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 mb-1">
                                                    <div class="form-group">
                                                        <select name="schedules[{{$loop->index}}][start_time]" value="{{$schedule['start_time']}}" class="form-control border-radius-5" required>
                                                            @for ($i = 0; $i < 24 * 2; $i++)
                                                                @php
                                                                    $time = \Carbon\Carbon::createFromTime(0, 0, 0)->addMinutes($i * 30);
                                                                @endphp
                                                                <option value="{{ $time->format('H:i') }}" {{ $schedule['start_time'] == $time->format('H:i') ? 'selected' : '' }}>{{ $time->format('h:i A') }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 mb-1">
                                                    <div class="form-group">
                                                        <select name="schedules[{{$loop->index}}][end_time]" value="{{$schedule['end_time']}}" class="form-control border-radius-5" required>
                                                            @for ($i = 0; $i < 24 * 2; $i++)
                                                                @php
                                                                    $time = \Carbon\Carbon::createFromTime(0, 0, 0)->addMinutes($i * 30);
                                                                @endphp
                                                                <option value="{{ $time->format('H:i') }}" {{ $schedule['end_time'] == $time->format('H:i') ? 'selected' : '' }}>{{ $time->format('h:i A') }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 mb-1">
                                                    <div class="form-group">
                                                        <select name="schedules[{{$loop->index}}][status]" value="{{$schedule['status']}}" class="form-control border-radius-5" required>
                                                            <option value="opened" {{ $schedule['status'] == 'opened' ? 'selected' : '' }}>@lang('Opened')</option>
                                                            <option value="closed" {{ $schedule['status'] == 'closed' ? 'selected' : '' }}>@lang('Closed')</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row gy-3">
                            <div class="col-lg-12">
                                <div class="rates-input-section">
                                    <div class="row mb-3 gy-3">
                                        <div class="col-lg-11 col-mb-10">
                                            <h5 class="font-weight-bold">@lang('Rates')</h5>
                                        </div>

                                        <div class="col-lg-1 col-md-2 text-end">
                                            <button type="button" class="btn btn--primary btn-block extra_rates">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row extraRates">
                                        <div class="data-extra-rates">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <input class="form-control" name="rates[0][title]" type="text" required placeholder="@lang('Title')">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <input class="form-control" name="rates[0][description]" type="text" required placeholder="@lang('Description')">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <input type="number" class="form-control" step="any" placeholder="@lang('Ex'). 5.50" name="rates[0][price]" value="{{ old('price') }}" required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row gy-3">
                            <div class="col-lg-12">
                                <div class="gym-input-section">
                                    <div class="row mb-3 gy-3">
                                        <div class="col-lg-11 col-mb-10">
                                            <h5 class="font-weight-bold">@lang('Gym Specification')</h5>
                                        </div>

                                        <div class="col-lg-1 col-md-2 text-end">
                                            <button type="button" class="btn btn--primary btn-block extra_service">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>


                                    <div class="row extraService">
                                        <div class="data-extra-service">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <input class="form-control" name="specification[0][name]" type="text" required placeholder="@lang('Name')">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <input class="form-control" name="specification[0][value]" type="text" required placeholder="@lang('Value')">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">@lang('Add gym image')</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="photo_upload">
                                                <div class="drag_area" id="dragArea">
                                                    <div class="drag_drop_content">
                                                        <span title="@lang('Click to add Image')" class="icon_wrap" role="button" id="selectFiles"><i class="las la-file-image"></i></span>
                                                    </div>
                                                    <input name="images[]" type="file" class="file" multiple id="fileInput" accept=".jpg, .png, .jpeg" required/>
                                                </div>
                                                <div class="container_area" id="containerArea">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">@lang('Add gym image')</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="photo_upload">
                                    <div class="drag_area" id="dragArea">
                                        <div class="drag_drop_content">
                                            <span title="@lang('Click to add Image')" class="icon_wrap" role="button" id="selectFiles"><i class="las la-file-image"></i></span>
                                        </div>
                                        <input name="images[]" type="file" class="file" multiple id="fileInput" accept=".jpg, .png, .jpeg" />
                                    </div>
                                    <div class="container_area" id="containerArea"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.product.index') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush



@push('style-lib')
<link rel="stylesheet" href="{{asset('assets/admin/css/datepicker.min.css')}}">
@endpush


@push('script-lib')
<script src="{{ asset('assets/admin/js/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/datepicker.en.js') }}"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places" ></script>
<script src="{{ asset('assets/common/js/find_location.js') }}"></script>
@endpush

@push('script')
    <script>
        (function ($) {
        })(jQuery);
    </script>
    <script>

        (function ($) {
            "use strict";

            var images = [];
            function selectFiles() {
                $("#fileInput").click();
            }

            function onFileSelect(event) {
                const files = event.target.files;
                if (files.length === 0) return;
                for (let i = 0; i < files.length; i++) {
                    if (files[i].type.split('/')[0] !== 'image') continue;
                    if (!images.some((e) => e.name == files[i].name)) {
                        images.push({
                            name: files[i].name,
                            url: URL.createObjectURL(files[i])
                        });
                    }
                }
                updateImages();
            }

            function deleteImage(index) {
                images.splice(index, 1);
                updateImages();
            }

            function updateImages() {
                $("#containerArea .image.uploaded").remove();
                images.forEach(function (image, index) {
                    var deleteButton = $(`<span class="delete deleteImage" data-index="${index}"><i class="las la-times"></i></span>`);
                    var imageDiv = $('<div class="image uploaded"></div>').append(deleteButton).append($('<img src="' + image.url + '" alt="..."/>'));
                    $("#containerArea").append(imageDiv);
                });
            }

            $(document).on('click', '.deleteImage', function () {
                const index = $(this).data('index');
                deleteImage(index);
            });

            $("#selectFiles").click(selectFiles);
            $("#fileInput").change(onFileSelect);

            var specCount = 1;

            var start = new Date(),
                prevDay,
                startHours = 0;

            start.setHours(0);
            start.setMinutes(0);

            if ([6, 0].indexOf(start.getDay()) != -1) {
                start.setHours(10);
                startHours = 10
            }

            $('#startDateTime').datepicker({
                timepicker: true,
                language: 'en',
                dateFormat: 'yyyy-mm-dd',
                startDate: start,
                minHours: startHours,
                maxHours: 23,
                onSelect: function (fd, d, picker) {
                    if (!d) return;

                    var day = d.getDay();

                    if (prevDay != undefined && prevDay == day) return;
                    prevDay = day;

                    if (day == 6 || day == 0) {
                        picker.update({
                            minHours: 0,
                            maxHours: 23
                        })
                    } else {
                        picker.update({
                            minHours: 0,
                            maxHours: 23
                        })
                    }
                }
            });

            $('#endDateTime').datepicker({
                timepicker: true,
                language: 'en',
                dateFormat: 'yyyy-mm-dd',
                startDate: start,
                minHours: startHours,
                maxHours: 23,
                onSelect: function (fd, d, picker) {

                    if (!d) return;

                    var day = d.getDay();

                    if (prevDay != undefined && prevDay == day) return;
                    prevDay = day;

                    if (day == 6 || day == 0) {
                        picker.update({
                            minHours: 0,
                            maxHours: 23
                        })
                    } else {
                        picker.update({
                            minHours: 0,
                            maxHours: 23
                        })
                    }
                }
            });

            $("[name=schedule]").on('change', function(e){
                var schedule = e.target.value;

                if(schedule != 1){
                    $("[name=started_at]").attr('disabled', true);
                    $('.started_at').css('display', 'none');
                    // $("[name=started_at]").val('');
                }else{
                    $("[name=started_at]").attr('disabled', false);
                    $('.started_at').css('display', 'block');
                }
            }).change();

            $('.categories-select').select2({
                dropdownParent: $('.card-body'),
                tags: true,
                tokenSeparators: [',']
            });

            $('.services-select').select2({
                dropdownParent: $('.card-body'),
                tags: true,
                tokenSeparators: [',']
            });

            $('.extra_service').on('click', function () {
                var index = $('.data-extra-service').length;
                var html = `
                    <div class="data-extra-service">
                        <div class="row">
                            <div class="col-11">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <input class="form-control" name="specification[${index}][name]" type="text" required placeholder="@lang('Name')">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <input class="form-control" name="specification[${index}][value]" type="text" required placeholder="@lang('Value')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-1 text-end">
                                <button type="button" class="btn btn--primary remove_extra_service"><i class="la la-times"></i></button>
                            </div>
                        </div>
                    </div>
                    `;
                $('.extraService').append(html);
            });

            $(document).on('click', '.remove_extra_service', function () {
                $(this).closest('.data-extra-service').remove();
            });

            $('.extra_rates').on('click', function () {
                var index = $('.data-extra-rates').length;
                var html = `
                    <div class="data-extra-rates">
                        <div class="row">
                            <div class="col-11">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <input class="form-control" name="rates[${index}][title]" type="text" required placeholder="@lang('Title')">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <input class="form-control" name="rates[${index}][description]" type="text" required placeholder="@lang('Description')">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <input class="form-control" name="rates[${index}][price]" type="text" required placeholder="@lang('Ex'). 5.50">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-1 text-end">
                                <button type="button" class="btn btn--primary remove_extra_rates"><i class="la la-times"></i></button>
                            </div>
                        </div>
                    </div>
                    `;
                $('.extraRates').append(html);
            });

            $(document).on('click', '.remove_extra_rates', function () {
                $(this).closest('.data-extra-rates').remove();
            });

        })(jQuery);
    </script>
@endpush
