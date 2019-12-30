<?php

namespace App\Http\Controllers\Api;

use App\Http\Queries\TopicQuery;
use App\Http\Requests\Api\TopicRequest;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TopicsController extends Controller
{
    public function index(Request $request, TopicQuery $query)
    {
//        $query = $topic->query();
//        if ($categoryId = $request->category_id) {
//            $query->where('category_id', $categoryId);
//        }
//        $topics = $query
//            ->with('user', 'category')
//            ->withOrder($request->order)
//            ->paginate();
//        $topics = QueryBuilder::for(Topic::class)
//            ->allowedIncludes('user', 'category')
//            ->allowedFilters([
//                'title',
//                AllowedFilter::exact('category_id'),
//                AllowedFilter::scope('withOrder')->default('recentReplied'),
//            ])->paginate();
        $topics = $query->paginate();
        return TopicResource::collection($topics);
    }

    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $request->user()->id;
        $topic->save();
        return new TopicResource($topic);
    }

    public function show($topicId, TopicQuery $query)
    {
//        $topic = QueryBuilder::for(Topic::class)
//            ->allowedIncludes('user', 'category')
//            ->findOrFail($topicId);
        $topic = $query->findOrFail($topicId);
        return new TopicResource($topic);
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());
        return new TopicResource($topic);
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();
        return response(null, 204);
    }

    //查询某个人发布的话题
    public function userIndex(Request $request, User $user, TopicQuery $query)
    {
//        $query = $user->topics()->getQuery();
//        $topics = QueryBuilder::for($query)
//            ->allowedIncludes('user', 'category')
//            ->allowedFilters([
//                'title',
//                AllowedFilter::exact('category_id'),
//                AllowedFilter::scope('withOrder')->default('recentReplied'),
//            ])
//            ->paginate();
        $topics = $query->where('user_id', $user->id)->paginate();
        return TopicResource::collection($topics);
    }
}
