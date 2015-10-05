@extends('media-manager::master')
@section('styles')
    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="/css/magnific-popup.css">
@stop
@section('content')

    <h1>Ex2 list</h1>
    <p class="lead">Here's a list of all your tasks. </p>
    <hr>

    <div>
        <table class="table table-striped table-bordered" style="margin-top: 0px;">
            <thead>
            <tr>
                <th width="3%">ID</th>
                <th width="25%">Avatar</th>
                <th width="10%">Name</th>
                <th width="50%">Description</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($ex2objects as $anObject)
                <tr>
                    <td style="vertical-align:middle">{{$anObject->id}}</td>
                    <td style="vertical-align:middle">
                        <div class="popup-link">
                            <a  href="/media/show/{{$anObject->avatarID}}"><img src="{{$anObject->thumbsURL}}" alt="">
                            </a>
                        </div>
                    </td>
                    <td style="vertical-align:middle">
                        <a href="/ex2edit/{{$anObject->id}}" class="" >{{$anObject->name}}</a>
                    </td>
                    <td style="vertical-align:middle">{{$anObject->description}}</td>
                    <td style="vertical-align:middle">{{$anObject->created_at}}</td>
                    <td style="vertical-align:middle">{{$anObject->updated_at}}</td>
                    <td style="vertical-align:middle">
                        {!! Form::open(array('method' => 'DELETE', 'route' => 'ex2delete')) !!}
                        <input name="document_id" type="hidden" value="{{$anObject->id}}">
                        <input name="entity_type" type="hidden" value="App\ex2Obj">
                        {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
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

            //$('.popup-link').magnificPopup({
             //   gallery: {
             //       enabled: true
             //   },
             //   type:'image'
            // });

            $('.popup-link').each(function() { // the containers for all your galleries
                $(this).magnificPopup({
                    delegate: 'a', // the selector for gallery item
                    type: 'image',
                    gallery: {
                        enabled:true
                    }
                });
            });

        });


    </script>
@stop