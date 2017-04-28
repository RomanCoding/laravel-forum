<?php

namespace App\Http\Controllers;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Fetch a model, check if it is likeable, store like.
     *
     * @param string $model
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($model, $id)
    {
        $model = "\\App\\{$model}";
        if ($this->isLikeable($model) && ! ($content = $model::findOrFail($id))->isLiked()) {
            $content->like(auth()->id());
        }
        return back();
    }

    /**
     * Check if model can be liked.
     *
     * @param string $model
     * @return bool
     */
    protected function isLikeable($model)
    {
        return method_exists($model, 'like');
    }
}
