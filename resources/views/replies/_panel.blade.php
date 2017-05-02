<div class="panel panel-default">
    <div class="panel-heading">
        <a href="{{ $reply->owner->profile() }}">
            {{ $reply->owner->name }}
        </a> said {{ $reply->created_at->diffForHumans() }}...
    </div>

    <div class="panel-body">
        {{ $reply->body }}
    </div>

    <form action="/likes/reply/{{$reply->id}}" method="POST">
        {{ csrf_field() }}
        <button type="submit" class="btn-primary btn-xs btn-info" {{ ($reply->isLiked() || !$auth) ? 'disabled' : '' }}>Like
            <span class="fa fa-heart"></span>
            {{ $reply->likes_count }}
        </button>
    </form>
</div>