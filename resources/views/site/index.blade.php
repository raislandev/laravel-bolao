@extends('layouts.app')

@section('content')
  <!-- Header -->
  <header class="masthead">
    <div class="container">
      <div class="intro-text">
        <div class="intro-lead-in">@lang('bolao.welcome_to_the_betting_website')</div>
        <div class="intro-heading text-uppercase">@lang('bolao.enjoy_with_your_family')</div>
        <a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="#portfolio">@lang('bolao.check_the_list_here')</a>
      </div>
    </div>
  </header>



  <!-- Portfolio Grid -->
  <section class="bg-light" id="portfolio">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">@lang('bolao.betting_list')</h2>
          <h3 class="section-subheading text-muted">@lang('bolao.join_or_create')</h3>
        </div>
      </div>
      <div class="row">
      @foreach ($list as $key => $value)
        <div class="col-md-4 col-sm-6 portfolio-item">
          <a class="portfolio-link" data-toggle="modal" href="#portfolioModal{{$value->id}}">
            <div class="portfolio-hover">
              <div class="portfolio-hover-content">
                <i class="fas fa-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="img/portfolio/apostas.jpeg" alt="">
          </a>
          <div class="portfolio-caption">
            <h4>{{$value->title}}</h4>
            <p class="text-muted">{{$value->user_name}}</p>
            @form_component(['action'=>route("sign",$value->id),'method'=>"POST"])
              <a class="btn btn-info" href="{{route('rounds',$value->id)}}">@lang('bolao.view_rounds')</a>
              <a class="btn btn-warning" href="{{route('classification',$value->id)}}">@lang('bolao.classification')</a>
              @if ($value->subscriber ?? false)
                  <button class="btn btn-danger" >@lang('bolao.place_bet')</button>
              @else
                  <button class="btn btn-success">@lang('bolao.participate')</button>
              @endif
            @endform_component
            
          </div>
        </div>
        @endforeach
  </section>





  <!-- Portfolio Modals -->

  <!-- Modal 1 -->
  @foreach ($list as $key => $value)
    <div class="portfolio-modal modal fade" id="portfolioModal{{$value->id}}" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="close-modal" data-dismiss="modal">
            <div class="lr">
              <div class="rl"></div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-lg-8 mx-auto">
                <div class="modal-body">
                  <!-- Project Details Go Here -->
                  <h2 class="text-uppercase">{{$value->title}}</h2>
                  <p class="item-intro text-muted">{{$value->user_name}}</p>
                  <p>@lang('bolao.this_pocket_has_the_following_rules')</p>
                  <ul class="list-inline">
                    <li>@lang('bolao.value_result'): {{$value->value_result}}</li>
                    <li>@lang('bolao.extra_value'): {{$value->extra_value}}</li>
                    <li>@lang('bolao.value_fee'): {{$value->value_fee}}</li>
                  </ul>
                  @form_component(['action'=>route("sign",$value->id),'method'=>"POST"])
                  <a class="btn btn-info" href="{{route('rounds',$value->id)}}">@lang('bolao.view_rounds')</a>
                  <a class="btn btn-warning" href="{{route('classification',$value->id)}}">@lang('bolao.classification')</a>
                  @if ($value->subscriber ?? false)
                    <button class="btn btn-danger" >@lang('bolao.place_bet')</button>
                  @else
                    <button class="btn btn-success">@lang('bolao.participate')</button>
                  @endif
                  
                  @endform_component   
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach
  
@endsection
