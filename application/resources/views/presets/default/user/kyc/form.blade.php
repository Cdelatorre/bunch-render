@extends($activeTemplate.'layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="table-boarder p-3">
                <h5 class="mb-4 mt-2">@lang('Fill up the bellow information')</h5>
                <form action="{{route('user.kyc.submit')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <x-custom-form identifier="act" identifierValue="kyc"></x-custom-form>

                    <div class="form-group text-end">
                        <button type="submit" class="btn btn--base border-none">@lang('Save')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
