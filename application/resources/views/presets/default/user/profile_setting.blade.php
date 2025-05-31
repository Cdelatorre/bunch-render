@extends($activeTemplate.'layouts.master')
@section('content')

<form method="post" enctype="multipart/form-data">
    @csrf
    <div class="row gy-4 justify-content-start profile-setting">
        <div class="col-md-12 col-sm-12 mt-4">
            <div class="images-upload-section">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">@lang('Your') @lang('Photos')</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="photo_upload">
                            <div class="drag_area" id="dragArea">
                                <div class="drag_drop_content">
                                    <span title="@lang('Click to add Image')" class="icon_wrap" role="button" id="selectFiles"><i class="las la-file-image"></i></span>
                                    {{-- <p role="button" id="selectFiles">@lang('Click to add Image')</p> --}}
                                </div>
                                <input name="images[]" type="file" class="file" multiple id="fileInput" accept=".jpg, .png, .jpeg" />
                            </div>
                            <div class="container_area" id="containerArea">
                                @if($product->productImages)
                                @forelse($product->productImages as $image)
                                    <div class="image">
                                        <span class="delete imageRemove" data-id="{{$image->id}}"><i class="las la-times" href="javascript:void(0)"></i></span>
                                        <img src="{{getImage(getFilePath('product').'/'.@$image->path.'/'.@$image->image) }}" alt="@lang('Boat Image')">
                                    </div>
                                @empty
                                @endforelse
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="profile-activities-section">
                <label class="w-100 font-weight-bold">@lang('Your') @lang('Activities')</label>
                <div class="action-category-wrapper">
                    @forelse($categories as $category)
                    <button type="button" data-id="{{ $category->id }}" id="btn_categories_{{$category->id}}" class="action-category-item btn-activity {{ in_array($category->id, $productCategories) ? 'selected' : '' }}">
                        <div class="action-category-item__icon">
                            @php echo $category->icon; @endphp
                        </div>
                        <div class="action-category-item__text">
                            <p>{{__(@$category->name)}}</p>
                        </div>
                    </button>
                    <input class="form-check-input filtered_category d-none" name="categories[]" type="checkbox" value="{{$category->id}}" id="categories_{{$category->id}}" {{ in_array($category->id, $productCategories) ? 'checked' : '' }}>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="profile-services-section">
                <label class="w-100 font-weight-bold">@lang('Your') @lang('Services')</label>
                <div class="action-services-wrapper">
                    @foreach ($rootServices as $services)
                    <span class="w-100 font-weight-bold">{{ $services->name }}</span>
                    <div class="action-category-wrapper">
                        @foreach ($services->children as $service)
                        <button type="button" data-id="{{ $service->id }}" id="btn_services_{{$service->id}}" class="action-category-item btn-service {{ in_array($service->id, $productServices) ? 'selected' : '' }}">
                            <div class="action-category-item__text">
                                <p>{{__(@$service->name)}}</p>
                            </div>
                        </button>
                        <input class="form-check-input filtered_category d-none" name="services[]" type="checkbox" value="{{$service->id}}" id="services_{{$service->id}}" {{ in_array($service->id, $productServices) ? 'checked' : '' }}>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-12 col-md-8">
            <div class="schedules-input-section">
                <div class="row mb-3 gy-3">
                    <div class="col-lg-11 col-mb-10">
                        <label class="w-100 font-weight-bold">@lang('Schedules')</label>
                    </div>
                </div>

                <div class="row extraSchedules">
                    @php
                        $schedules = json_decode($product->schedules, true) ?? [[
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
                    @forelse($schedules as $schedule)
                    <div class="data-extra-schedules mb-3">
                        <div class="row">
                            <div class="col-12 col-md-3 mb-2">
                                <div class="form-group">
                                    <input class="form-control custom-form-field" name="schedules[{{$loop->index}}][name]" type="text" required readonly border-none placeholder="@lang('Name')"  value="{{$schedule['name']}}">
                                </div>
                            </div>
                            <div class="col-4 col-md-3 mb-1">
                                <div class="form-group">
                                    <select name="schedules[{{$loop->index}}][start_time]" value="{{$schedule['start_time']}}" class="form--control form-dark-select" required>
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
                                    <select name="schedules[{{$loop->index}}][end_time]" value="{{$schedule['end_time']}}" class="form--control form-dark-select" required>
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
                                    <select name="schedules[{{$loop->index}}][status]" value="{{$schedule['status']}}" class="form--control form-dark-select" required>
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

        <div class="col-md-12 col-sm-12 mt-4">
            <button type="submit" class="btn btn--base border-none">
                @lang('Save Changes')
            </button>
        </div>
    </div>
</form>

{{-- Edit Model Start --}}
<div class="modal fade" id="imageRemoveBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog custom--modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Image Delete Confirmation')</h5>
                <button type="button" class="btn--close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('user.product.delete') }}" method="post">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to remove this image?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn--sm btn btn--base outline" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--sm btn--base border-none">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Edit Model End --}}

@endsection

@push('script')
    <script>
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

        $(document).on('click', '.btn-activity', function () {
            const activityId = $(this).data('id');

            const $checkbox = $(`input[type="checkbox"][id^="categories_${activityId}"]`);
            $(this).toggleClass('selected');
            $checkbox.prop('checked', $(this).hasClass('selected'));
        });

        $(document).on('click', '.btn-service', function () {
            const serviceId = $(this).data('id');

            const $checkbox = $(`input[type="checkbox"][id^="services_${serviceId}"]`);
            $(this).toggleClass('selected');
            $checkbox.prop('checked', $(this).hasClass('selected'));
        });

        $(document).on('click', '.imageRemove', function () {
            var modal = $('#imageRemoveBy');
            modal.find('input[name=id]').val($(this).data('id'))
            modal.modal('show');
        });
    </script>
@endpush