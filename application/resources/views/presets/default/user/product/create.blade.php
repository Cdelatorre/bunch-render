@extends($activeTemplate.'layouts.master')
@section('content')
<div class="dashboard-boarder">
    <div class="row gy-4">
        <div class="col-lg-12">
            <form id="createForm" action="{{ route('user.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row gy-4">
                    <div class="col-sm-12 col-xl-4 col-lg-6 mb-15">
                        <div class="form-group">
                            <label for="title" class="form--label">@lang('Title')</label>
                            <input type="text" id="title" class="form--control" placeholder="@lang('Title')" name="title" value="{{ old('title') }}" required/>
                            </div>
                    </div>

                    <div class="col-sm-12 col-xl-4 col-lg-6 mb-15">
                        <div class="form-group">
                            <label for="category" class="form--label">@lang('Category')</label>
                            <select name="category" id="category" class="select form--control">
                                <option value="">@lang('Select Category')</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-xl-4 col-lg-6 mb-15">
                        <div class="form-group">
                            <label for="price" class="form--label">@lang('Price')</label>
                            <input type="number" id="price" class="form--control" step="any" min="1" placeholder="@lang('Price Ex'). 5.50" name="price" value="{{ old('price') }}" required/>
                            </div>
                    </div>

                    <div class="col-sm-12 col-xl-4 col-lg-6 mb-15">
                        <div class="form-group">
                            <label for="schedule" class="form--label">@lang('Schedule')</label>
                            <select name="schedule" id="schedule" class="select form--control" required>
                                <option value="">@lang('Select Schedule')</option>
                                <option value="1">@lang('Yes')</option>
                                <option value="0">@lang('No')</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4 col-lg-6 mb-15 started_at">
                        <div class="form-group">
                            <label for="startDateTime" class="form--label">@lang('Started At')</label>
                            <input type="text" name="started_at" placeholder="@lang('Select Start Date & Time')" id="startDateTime" data-position="bottom left" class="form--control" value="{{ old('date_time') }}" autocomplete="off" required/>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4 col-lg-6 mb-15">
                        <div class="form-group">
                            <label for="endDateTime" class="form--label">@lang('Expired At')</label>
                            <input type="text"  name="expired_at" placeholder="@lang('Select End Date & Time')" id="endDateTime" data-position="bottom left" class="form--control" value="{{ old('date_time') }}" autocomplete="off" required/>
                        </div>
                    </div>
                    <div class="col-12 d-none">
                        <div class="form-group">
                            <label for="shortdescription" class="form--label">@lang('Short Description')</label>
                            <textarea rows="3" id="shortdescription" class="form--control" name="short_description" placeholder="@lang('Short Description')">{{ old('short_description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mt-3">
                            <label for="descripiton" class="form--label">@lang('Description')</label>
                            <textarea id="descripiton" rows="8" class="form--control trumEdit" name="description" placeholder="@lang('Description of the Gym')">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row gy-3">
                    <div class="col-lg-12">

                            <div class="row my-3 gy-3">
                                <div class="col-lg-11 col-10">
                                    <h5 class="py-3">@lang('Gym Specification')</h5>
                                </div>

                                <div class="col-lg-1 col-2 text-end">
                                    <button type="button" class="btn btn--sm btn--base border-none btn-block extra_service">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>


                            <div class="row extraService">
                                <div class="data-extra-service mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <input class="form--control" name="specification[0][name]" type="text" required placeholder="@lang('Name')">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <input class="form--control" name="specification[0][value]" type="text" required placeholder="@lang('Value')">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label>@lang('Add gym image')</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="photo_upload">
                            <div class="drag_area" id="dragArea" draggable="true">
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

                <div class="row py-3">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn--base border-none">@lang('Submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@push('style-lib')
    <link rel="stylesheet" href="{{asset('assets/admin/css/datepicker.min.css')}}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/datepicker.en.js') }}"></script>
@endpush

@push('script')
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
                }else{
                    $("[name=started_at]").attr('disabled', false);
                    $('.started_at').css('display', 'block');
                }
            }).change();


            $('.extra_service').on('click', function () {
            var index = $('.data-extra-service').length;
            var html = `
                <div class="data-extra-service">
                    <div class="row align-items-center">
                        <div class="col-sm-11 col-10">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input class="form--control" name="specification[${index}][name]" type="text" required placeholder="@lang('Name')">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input class="form--control" name="specification[${index}][value]" type="text" required placeholder="@lang('Value')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1 col-2 text-end">
                            <button type="button" class="btn btn--sm btn--danger remove_extra_service border-none"><i class="la la-times"></i></button>
                        </div>
                    </div>
                </div>
                `;
            $('.extraService').append(html);
        });

        $(document).on('click', '.remove_extra_service', function () {
            $(this).closest('.data-extra-service').remove();
        });


        })(jQuery);
    </script>
@endpush
