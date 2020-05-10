@extends('layouts.app')

@section('content')
    @page_component(['col'=>12, 'page'=>__('bolao.show_crud',['page'=>$page2])])

          @alert_component(['msg'=>session('msg'), 'status'=>session('status')])
          @endalert_component

          @breadcrumb_component(['page'=>$page,'items'=>$breadcrumb ?? []])
          @endbreadcrumb_component

          <p>{{ __('bolao.title') }}:{{$register->title}}</p>
          <p>{{ __('bolao.betting_title') }}:{{$register->betting_title}}</p>
          <p>{{ __('bolao.date_start') }}:{{$register->date_start_site}}</p>
          <p>{{ __('bolao.date_end') }}:{{$register->date_end_site}}</p>

          @if ($delete)
            @form_component(['action'=>route($routeName.".destroy",$register->id),'method'=>"DELETE"])

              <button class="btn btn-danger btn-lg">@lang('bolao.delete')</button>
            @endform_component
          @endif




    @endpage_component
@endsection
