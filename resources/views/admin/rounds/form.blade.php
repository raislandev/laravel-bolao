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
    <label for="title">{{ __('bolao.bet') }}</label>
      <select class="form-control{{ $errors->has('betting_id') ? ' is-invalid' : '' }}" name="betting_id" >
        @foreach ($listRel as $key => $value)
          @php
            $select = '';

            if(old('betting_id')){
              if(old('betting_id') == $value->id){
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
      @if ($errors->has('betting_id'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('betting_id') }}</strong>
        </span>
      @endif
  </div>

  <div class="form-group col-6">
    <label for="date_start">{{ __('bolao.date_start') }} ({{date('d/m/Y H:i:s')}})</label>
    <input type="datetime" placeholder="{{date('d/m/Y H:i:s')}}" class="form-control{{ $errors->has('date_start') ? ' is-invalid' : '' }}" name="date_start" value="{{ old('date_start') ?? ($register->date_start_site ?? '') }}">
    @if ($errors->has('date_start'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('date_start') }}</strong>
        </span>
    @endif

  </div>

  <div class="form-group col-6">
    <label for="date_end">{{ __('bolao.date_end') }} ({{date('d/m/Y H:i:s')}})</label>
    <input type="datetime" placeholder="{{date('d/m/Y H:i:s')}}" class="form-control{{ $errors->has('date_end') ? ' is-invalid' : '' }}" name="date_end" value="{{ old('date_end') ?? ($register->date_end_site ?? '') }}">
    @if ($errors->has('date_end'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('date_end') }}</strong>
        </span>
    @endif

  </div>


</div>
