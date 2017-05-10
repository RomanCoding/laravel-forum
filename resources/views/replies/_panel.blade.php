<reply :reply="{{ json_encode(['id' => $reply->id, 'body' => $reply->body]) }}"inline-template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="{{ $reply->owner->profile() }}">
                {{ $reply->owner->name }}
            </a> said {{ $reply->created_at->diffForHumans() }}...
        </div>

        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                    <button class="btn btn-primary btn-xs" @click="update">Update</button>
                    <button class="btn btn-link btn-xs" @click="cancel">Cancel</button>
                </div>
            </div>
            <div v-else v-text="body"></div>
        </div>

        <form action="/likes/reply/{{$reply->id}}" method="POST">
            {{ csrf_field() }}
            <button type="submit"
                    class="btn-primary btn-xs btn-info" {{ (!$auth || $reply->isLiked()) ? 'disabled' : '' }}>Like
                <span class="fa fa-heart"></span>
                {{ $reply->likes_count }}
            </button>
        </form>
        @can('edit', $reply)
            <button class="btn btn-primary btn-xs" @click="editing=true">Edit</button>
            <form action="/replies/{{ $reply->id }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-danger btn-xs">Delete</button>
            </form>
        @endcan
    </div>
</reply>
