@extends('layouts.app')

@section('content')
    @page_component(['col'=>12, 'page'=>__('bolao.show_crud',['page'=>$page2])])

          @alert_component(['msg'=>session('msg'), 'status'=>session('status')])
          @endalert_component

          @breadcrumb_component(['page'=>$page,'items'=>$breadcrumb ?? []])
          @endbreadcrumb_component

          <p>{{ __('bolao.title') }}: {{$register->title}}</p>
          <p>{{ __('bolao.stadium') }}: {{$register->stadium}}</p>
          <p>{{ __('bolao.team_a') }}: {{$register->team_a}}</p>
          <p>{{ __('bolao.team_b') }}: {{$register->team_b}}</p>
          <p>{{ __('bolao.result') }}: {{$register->result}}</p>
          <p>{{ __('bolao.scoreboard_a') }}: {{$register->scoreboard_a}}</p>
          <p>{{ __('bolao.scoreboard_b') }}: {{$register->scoreboard_b}}</p>
          <p>{{ __('bolao.date') }}: {{$register->date_site}}</p>

          @if ($delete)
            @form_component(['action'=>route($routeName.".destroy",$register->id),'method'=>"DELETE"])

              <button class="btn btn-danger btn-lg">@lang('bolao.delete')</button>
            @endform_component
          @endif




    @endpage_component
@endsection
