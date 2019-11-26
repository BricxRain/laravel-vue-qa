<?php

namespace App;

use App\Traits\Votable;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use Votable;

    protected $fillable = [
        'title',
        'body'
    ];

    protected $appends = [
        'created_date',
        'is_favorited',
        'favorite_count',
        'body_html'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('vote_count', 'DESC');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps(); //'question_id', 'user_id'
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    // Accessor fo cleaning javascript tags when saving in the database
    // public function setBodyAttribute($value)
    // {
    //     $this->attributes['body'] = clean($value);
    // }

    public function getUrlAttribute()
    {
        return route('questions.show', $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        if ($this->answer_count > 0) {
            if ($this->best_answer_id) {
                return "answered-accepted";
            }
            return "answer";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {
        return clean($this->bodyHtml());
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
    
    public function getFavoriteCountAttribute()
    {
        return $this->favorites->count();
    }
    
    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }
    
    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    private function bodyHtml()
    {
        return \Parsedown::instance()->text($this->body);
    }

    private function excerpt($length)
    {
        return str_limit(strip_tags($this->bodyHtml()), $length);
    }
}
