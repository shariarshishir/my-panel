@if(Session::has('message'))
   <div class="alert alert-success" role="alert">
   <strong></strong>{{Session::get('message')}}
   </div>
@endif
@if(Session::has('failedMessage'))
   <div class="alert alert-danger" role="alert">
   <strong></strong>{{Session::get('failedMessage')}}
   </div>
@endif

@if(count($errors)>0)
   <div class="alert alert-danger" role="alert">
    <strong>Errors:</strong>
    <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
   </div>
@endif
