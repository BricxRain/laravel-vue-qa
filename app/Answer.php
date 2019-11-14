<?php

namespace App;

use App\Traits\Votable;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use Votable;

    protected $fillable = [
        'body',
        'user_id'
    ];

    protected $appends = [
        'created_date'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public static function boot()
    {
        parent::boot();
    
        static::created(function($answer) {
            $answer->question->increment('answer_count');
        });

        static::deleted(function($answer) {
            $answer->question->decrement('answer_count');
        });
    }

    public function getBodyHtmlAttribute()
    {
        return clean(\Parsedown::instance()->text($this->body));
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        return $this->isBest() ? 'vote-accepted' : '';
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    public function isBest()
    {
        return $this->id === $this->question->best_answer_id ? 'vote-accepted' : '';
    }
}
