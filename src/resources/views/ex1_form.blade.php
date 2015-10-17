@extends('MediaManager::master')

@section('content')
    @if(Session::has('error'))
        <p class="errors">{!! Session::get('error') !!}</p>
    @endif
<div class="row " style="margin-top: 5px;">
    {!! Form::open(array('url' => '/ex1upload', 'class' => '', 'method' => 'post', 'files'=>true)) !!}

    <input name="mediaable_type" type="hidden"  value="App\exObj1"/>

    <div class="col-xs-6 col-md-6 adjustabit2 pull-left ">
        {!! Form::file('file[]', array('multiple'=>true)) !!}
    </div>
    <div class="col-xs-2 col-md-2  ">
        <input class="" type="text" name="caption" size="22" placeholder="caption...">
        <input class="" type="text" name="description" size="22" placeholder="description...">
        <input name="mediaable_id" type="text"   placeholder="ex1obj ID..." />
    </div>

    <div class="col-xs-2 col-md-2">
        <input class="pure-button pure-button-primary pull-right" type="submit" value="Upload">
    </div>
    {!! Form::close() !!}
</div>

@stop