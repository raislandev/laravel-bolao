<div class="row">
  <div class="form-group col-6">
    <label for="title">{{ __('bolao.title') }}</label>
    <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') ?? ($register->title ?? '') }}">
    @if ($errors->has('title'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
    @endif

  </div>

  <div class="form-group col-6">
    <label for="title">{{ __('bolao.round') }}</label>
      <select class="form-control{{ $errors->has('round_id') ? ' is-invalid' : '' }}" name="round_id" >
        @foreach ($listRel as $key => $value)
          @php
            $select = '';

            if(old('round_id')){
              if(old('round_id') == $value->id){
                $select = 'selected';
              } 
            }else{
              if($register_id ?? false){
                if($register_id == $value->id){
                  $select = 'selected';
                }
              }
            }  
          @endphp
          <option {{$select}} value="{{$value->id}}">{{$value->title}}</option>
        @endforeach
      </select>
      @if ($errors->has('round_id'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('round_id') }}</strong>
        </span>
      @endif
  </div>

  <div class="form-group col-6">
    <label for="title">{{ __('bolao.stadium') }}</label>
    <input type="text" class="form-control{{ $errors->has('stadium') ? ' is-invalid' : '' }}" name="stadium" value="{{ old('stadium') ?? ($register->stadium ?? '') }}">
    @if ($errors->has('stadium'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('stadium') }}</strong>
        </span>
    @endif

  </div>

  <div class="form-group col-6">
    <label for="title">{{ __('bolao.result') }} {{ __('bolao.result_description') }}</label>
      <select class="form-control{{ $errors->has('result') ? ' is-invalid' : '' }}" name="result" >
        
        @php
           $lista = ['A','B','E']
        @endphp

        @foreach ($lista as $key => $value)
          @php
            $select = '';

            if(old('result')){
              if(old('result') == $value){
                $select = 'selected';
              } 
            }else{
              if($register->result ?? false){
                if($register->result == $value){
                  $select = 'selected';
                }
              }else{
                if($value == 'E'){
                  $select = 'selected';
                }
              }
            }  
          @endphp
          <option {{$select}} value="{{$value}}">{{$value}}</option>
        @endforeach
      </select>
      @if ($errors->has('result'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('result') }}</strong>
        </span>
      @endif
  </div>

  <div class="form-group col-6">
    <label for="title">{{ __('bolao.team_a') }}</label>
    <input type="text" class="form-control{{ $errors->has('team_a') ? ' is-invalid' : '' }}" name="team_a" value="{{ old('team_a') ?? ($register->team_a ?? '') }}">
    @if ($errors->has('team_a'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('team_a') }}</strong>
        </span>
    @endif

  </div>

  <div class="form-group col-6">
    <label for="title">{{ __('bolao.team_b') }}</label>
    <input type="text" class="form-control{{ $errors->has('team_b') ? ' is-invalid' : '' }}" name="team_b" value="{{ old('team_b') ?? ($register->team_b ?? '') }}">
    @if ($errors->has('team_b'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('team_b') }}</strong>
        </span>
    @endif

  </div>

  <div class="form-group col-6">
    <label for="title">{{ __('bolao.scoreboard_a') }}</label>
    <input type="text" class="form-control{{ $errors->has('scoreboard_a') ? ' is-invalid' : '' }}" name="scoreboard_a" value="{{ old('scoreboard_a') ?? ($register->scoreboard_a ?? '0') }}">
    @if ($errors->has('scoreboard_a'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('scoreboard_a') }}</strong>
        </span>
    @endif

  </div>

  <div class="form-group col-6">
    <label for="title">{{ __('bolao.scoreboard_b') }}</label>
    <input type="text" class="form-control{{ $errors->has('scoreboard_b') ? ' is-invalid' : '' }}" name="scoreboard_b" value="{{ old('scoreboard_b') ?? ($register->scoreboard_b ?? '0') }}">
    @if ($errors->has('scoreboard_b'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('scoreboard_b') }}</strong>
        </span>
    @endif

  </div>


  <div class="form-group col-6">
    <label for="date">{{ __('bolao.date') }} ({{date('d/m/Y H:i:s')}})</label>
    <input type="datetime" placeholder="{{date('d/m/Y H:i:s')}}" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" value="{{ old('date') ?? ($register->date_site ?? '') }}">
    @if ($errors->has('date'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('date') }}</strong>
        </span>
    @endif

  </div>


</div>
