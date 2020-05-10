<table class="table">
  <thead>
    <tr>
      @foreach ($columnList as $key => $value)
        <th scope="col">{{$value}}</th>
      @endforeach
      @if($routeName ?? false)
        <th scope="col">@lang('bolao.action')</th>
      @endif
    </tr>
  </thead>
  <tbody>
    @php
    $count = 1;
    @endphp
    @foreach ($list as $key => $value)
      <tr>
        @foreach ($columnList as $key2 => $value2)
          @if ($key2 == 'id')
            <th scope="row">@php  echo $value->{$key2} @endphp</th>
          @elseif($key2 == 'OrderAsc')
            <td>@php  echo $count++ @endphp</td>
          @elseif($key2 == 'pivot_points')
            <td>@php  echo $value->pivot->points @endphp</td>
          @else 
            <td>@php  echo $value->{$key2} @endphp</td>  
          @endif
        @endforeach
        @if($routeName ?? false)
            @if ($value->date_start && $value->date_end)
                @if (new DateTime() >= new DateTime($value->date_start) && new DateTime() <= new DateTime($value->date_end ))
                  <td>
                    <a href="{{route($routeName, $value->id)}}"><i style="color:black" class="material-icons">pageview</i></a>
                  </td>
                @else
                  <td>
                    <a onclick="return false;" href="{{route($routeName, $value->id)}}"><i style="color:gray" class="material-icons">pageview</i></a>
                  </td>
                @endif
            @else
                <td>
                  <a href="{{route($routeName, $value->id)}}"><i style="color:black" class="material-icons">pageview</i></a>
                </td>    
            @endif
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
<script>
  $('#disabled').click(function(e){
      e.preventDefault();
  });
</script>