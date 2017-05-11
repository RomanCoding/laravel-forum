<reply :reply="{{ json_encode(['id' => $reply->id, 'body' => $reply->body]) }}" inline-template v-cloak>

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

        <like :subject="{{ json_encode(['model' => 'reply', 'id' => $reply->id, 'body' => $reply->body, 'likesCount' => $reply->likesCount, 'isLiked' => $reply->isLiked]) }}"></like>
        @can('edit', $reply)
            <button class="btn btn-primary btn-xs" @click="editing=true">Edit</button>
            <button class="btn btn-danger btn-xs" @click="destroy">Delete</button>
        @endcan
    </div>
</reply>
