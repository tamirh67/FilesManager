
@extends('media-manager::master')

@section('styles')
@stop

@section('content')

<script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">

<form action="/ex2upload"
      class="dropzone"
      id="dz1">
    {!! csrf_field() !!}
    <input name="mediaable_id" type="text"  />
    <input name="mediaable_type" type="hidden"  value="App\exObj2"/>
    <div class="fallback">
        <input name="files" type="file" multiple />
    </div>

</form>

@stop