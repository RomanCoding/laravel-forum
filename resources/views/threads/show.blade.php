@extends('layouts.app')

@section('content')
    <thread :init-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="/threads">Forum</a></li>
                <li><a href="{{ $thread->channel->path() }}">{{ $thread->channel->name }}</a></li>
                <li class="active"><a href="{{ $thread->path() }}">{{ $thread->title }}</a></li>
            </ol>
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="{{ $thread->creator->profile() }}">{{ $thread->creator->name }}</a> posted:
                            {{ $thread->title }}
                            @can('delete', $thread)
                                <form action="{{ $thread->path() }}" class="pull-right" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-link" type="submit">Delete thread</button>
                                </form>
                            @endcan
                        </div>

                        <div class="panel-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <replies @removed="repliesCount--" @added='repliesCount++'></replies>

                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Posted by <a
                                    href="{{ $thread->creator->profile() }}">{{ $thread->creator->name }}</a> {{ $thread->created_at->diffForHumans() }}
                        </div>

                        <div class="panel-body">
                            This thread
                            has <span v-text="repliesCount"></span> {{ str_plural('reply', $thread->replies_count) }}.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread>
@endsection
