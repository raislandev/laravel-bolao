@extends('layouts.app')

@section('content')
    @page_component(['col'=>12, 'page'=>$page])

          @alert_component(['msg'=>session('msg'), 'status'=>session('status')])
          @endalert_component

          @breadcrumb_component(['page'=>$page,'items'=>$breadcrumb ?? []])
          @endbreadcrumb_component

          @form_component(['action'=>route($routeName.".update",$register->id),'method'=>"PUT"])
            @include('site.form')
            <button class="btn btn-primary btn-lg float-right">@lang('bolao.add')</button>
          @endform_component

    @endpage_component
@endsection
