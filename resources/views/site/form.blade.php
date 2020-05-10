<div class="row">

  <div class="form-group col-6">
    <label for="scoreboard_a">{{$register->team_a}}</label>
    <input type="text" class="form-control{{ $errors->has('scoreboard_a') ? ' is-invalid' : '' }}" name="scoreboard_a" value="{{ old('scoreboard_a') ?? ($register->scoreboard_a_betting ?? '0') }}">
    @if ($errors->has('scoreboard_a'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('scoreboard_a') }}</strong>
        </span>
    @endif

  </div>

  <div class="form-group col-6">
    <label for="scoreboard_b">{{$register->team_b}}</label>
    <input type="text" class="form-control{{ $errors->has('scoreboard_b') ? ' is-invalid' : '' }}" name="scoreboard_b" value="{{ old('scoreboard_b') ?? ($register->scoreboard_b_betting  ?? '0') }}">
    @if ($errors->has('scoreboard_b'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('scoreboard_b') }}</strong>
        </span>
    @endif

  </div>




</div>
