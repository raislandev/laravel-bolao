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
    <label for="value_result">{{ __('bolao.value_result') }}</label>
    <input type="text" class="form-control{{ $errors->has('value_result') ? ' is-invalid' : '' }}" name="value_result" value="{{ old('value_result') ?? ($register->value_result ?? '') }}">
    @if ($errors->has('value_result'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('value_result') }}</strong>
        </span>
    @endif

  </div>

  <div class="form-group col-6">
    <label for="extra_value">{{ __('bolao.extra_value') }}</label>
    <input type="text" class="form-control{{ $errors->has('extra_value') ? ' is-invalid' : '' }}" name="extra_value" value="{{ old('extra_value') ?? ($register->extra_value ?? '') }}">
    @if ($errors->has('extra_value'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('extra_value') }}</strong>
        </span>
    @endif

  </div>

  <div class="form-group col-6">
    <label for="value_fee">{{ __('bolao.value_fee') }}</label>
    <input type="text" class="form-control{{ $errors->has('value_fee') ? ' is-invalid' : '' }}" name="value_fee" value="{{ old('value_fee') ?? ($register->value_fee ?? '') }}">
    @if ($errors->has('value_fee'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('value_fee') }}</strong>
        </span>
    @endif

  </div>


</div>
