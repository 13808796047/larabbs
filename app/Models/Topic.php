<?php

namespace App\Models;


use Spatie\QueryBuilder\QueryBuilder;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    //重写路由模型
    public function resolveRouteBinding($value)
    {
        return QueryBuilder::for(self::class)
            ->allowedIncludes('user', 'category')
            ->where($this->getRouteKeyName(), $value)
            ->first();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithOrder($query, $order)
    {
        //不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentReplied();
                break;
        }
        //预加载防止N+1问题
        return $query->with('user', 'category');
    }

    public function scopeRecentReplied($query)
    {
        //当话题有新回复时，我们将编写逻辑来更新话题模型的reply_count属性
        //此时会自动触发框架对数据模型updated_at 时间的更新
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query)
    {
        //按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }

    //路由转换
    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], (array)$params));
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    //更新回复数
    public function updateReplyCount()
    {
        $this->reply_count = $this->replies->count();
        $this->save();
    }
}
