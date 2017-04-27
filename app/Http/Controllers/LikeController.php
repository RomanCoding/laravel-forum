<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($model, $id)
    {
        $model = '\\App\\' . $model;
        if ($this->isLikeable($model) && ! $this->isLiked($model, $id)) {
            $model::findOrFail($id)->like(auth()->id());
        }
        return back();
    }

    /**
     * Check if object was liked by current user.
     *
     * @param $model
     * @param $id
     * @return mixed
     */
    protected function isLiked($model, $id)
    {
        return $model::findOrFail($id)->likes()->where([
                'user_id' => auth()->id()
        ])->exists();
    }

    /**
     * Check if model can be liked.
     *
     * @param $model
     * @return bool
     */
    protected function isLikeable($model)
    {
        return method_exists($model, 'like');
    }
}
