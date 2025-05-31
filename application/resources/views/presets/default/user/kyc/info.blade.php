@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 table-boarder">
                @if($user->kyc_data)
                        <h5 class="text-center my-2">@lang('Your given KYC information')</h5>
                @endif
                    <div class="mt-2">
                        @if($user->kyc_data)
                        <ul class="list-group">
                          @foreach($user->kyc_data as $val)
                          @continue(!$val->value)
                          <li class="list--group--item d-flex justify-content-between align-items-center">
                            {{__($val->name)}}
                            <span>
                                @if($val->type == 'checkbox')
                                    {{ implode(',',$val->value) }}
                                @elseif($val->type == 'file')
                                    <a href="{{ route('user.attachment.download',encrypt(getFilePath('verify').'/'.$val->value)) }}" class="me-3"><i class="fa fa-file"></i>  @lang('Attachment') </a>
                                @else
                                <p>{{__($val->value)}}</p>
                                @endif
                            </span>
                          </li>
                          @endforeach
                          <li class="list--group--item d-flex justify-content-between align-items-center border-bottom-0">
                            @lang('Status')
                            <span>
                                @if(auth()->user()->kv == 2)
                                    <span class="badge badge--warning">@lang('Pending')</span>
                                @elseif(auth()->user()->kv == 1)
                                    <span class="badge badge--success">@lang('Verified')</span>
                                @endif
                            </span>

                          </li>
                        </ul>
                        @else
                        <h5 class="text-center">@lang('KYC data not found')</h5>
                        @endif
                    </div>

            </div>
        </div>
    </div>
@endsection
