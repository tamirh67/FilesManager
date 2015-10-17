@extends('MediaManager::master')

@section('styles')
    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="/css/magnific-popup.css">
@stop

@section('content')

    @if(Session::has('error'))
        <p class="errors">{!! Session::get('error') !!}</p>
    @endif

    <div class="row " style="margin-top: 5px;">
        {!! Form::open(array('url' => '/ex2update', 'class' => '', 'method' => 'post')) !!}
        {!! Form::label('name', 'Edit ex2object' ) !!}
        <input name="mediaable_type" type="hidden"  value="exObj2"/>

        <div class="form-group">
            <div class="row">
                <input class="" type="text" name="name" size="22" value="{{$theObject->name}}">
            </div>
            <div class="row">
                <input class="" type="text" name="description" size="120" value="{{$theObject->description}}">
            </div>

            <div class="row">
                <div class="">
                    <input name="mediaable_id" type="text"  readonly size="22" value="{{$theObject->id}}" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="">
                    <input class="pure-button pure-button-primary pull-left" type="submit" value="Update">
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div>
        <table class="table table-striped table-bordered" style="margin-top: 0px;">
            <thead>
            <tr>
                <th width="15%">Thumb</th>
                <th width="15%">Name</th>
                <th width="15%">ID</th>
                <th width="10%">Caption</th>
                <th width="20%">Description</th>
                <th>Created at</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($theDocuments as $aDocument)
                <tr>
                    <td style="vertical-align:middle">
                        <a
                            @if ($aDocument->filetype=='jpg' or $aDocument->filetype=='jpeg' or $aDocument->filetype=='png'
                                or $aDocument->filetype=='gif')
                                class="popup-link" href="/media/show/{{$aDocument->id}}"
                                @else
                                    href="#"
                            @endif
                            ><img  src="{{$aDocument->thumbsUrl}}" alt=""></a></td>
                    <td style="vertical-align:middle">
                        <a  href="/media/show/{{$aDocument->id}}">{{$aDocument->displayname}}</a>
                    </td>
                    <td style="vertical-align:middle">{{$aDocument->id}}</td>
                    <td style="vertical-align:middle">{{$aDocument->caption}}</td>
                    <td style="vertical-align:middle">{{$aDocument->description}}</td>
                    <td style="vertical-align:middle">{{$aDocument->created_at}}</td>
                    <td style="vertical-align:middle">
                        {!! Form::open(array('route' => 'documentdelete')) !!}
                        <input name="id" type="hidden" value="{{$aDocument->id}}">
                        <input name="mediaable_id" type="hidden" value="{{$theObject->id}}">
                        <input name="mediaable_type" type="hidden" value="App\ex2Obj">
                        {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                        {!! Form::close() !!}

                        {!! Form::open(array('route' => 'makeavatar')) !!}
                        <input name="object_id" type="hidden" value="{{$theObject->id}}">
                        <input name="doc_id" type="hidden" value="{{$aDocument->id}}">
                        <input name="mediaable_id" type="hidden" value="{{$theObject->id}}">
                        <input name="mediaable_type" type="hidden" value="App\ex2Obj">
                        {!! Form::submit('Avatar', array('class' => 'btn btn-success')) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@stop

@section('scripts')
    <!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <!-- Magnific Popup core JS file -->
    <script src="/js/jquery.magnific-popup.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.popup-link').magnificPopup({
                gallery: {
                    enabled: true
                },
                type:'image'

            });
            // $('#lightGallery').lightGallery();
        });
    </script>
@stop