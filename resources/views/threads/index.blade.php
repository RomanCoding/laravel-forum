@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @forelse($threads as $thread)
                    @include('threads._panel')
                @empty
                    <p>This channel is currently empty, browse another channel :)</p>
                @endforelse
                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection
