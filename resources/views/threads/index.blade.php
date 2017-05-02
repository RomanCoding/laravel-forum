@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @foreach ($threads as $thread)
                    @include('threads._panel')
                @endforeach
                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection
