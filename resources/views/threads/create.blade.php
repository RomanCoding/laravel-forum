@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create new thread</div>

                    <div class="panel-body">
                        <form method="POST" action="/threads">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="channel_id">Forum channel</label>
                                <select name="channel_id" id="channel_id" class="form-control">
                                    <option value="">Select one</option>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ (old('channel_id') == $channel->id) ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                            </div>

                            <div class="form-group">
                                <textarea name="body" class="form-control" id="body" cols="30" rows="5" placeholder="Thread body">{{ old('body') }}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>

                            @if(count($errors))
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
