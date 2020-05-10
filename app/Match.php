<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [
      'round_id',
      'title',
      'stadium',
      'team_a',
      'team_b',
      'result',
      'scoreboard_a',
      'scoreboard_b',
      'date',
    ];

    public function round()
    {
        return $this->belongsTo('App\Round');
    }

    public function users()
    {
      return $this->belongsToMany('App\User')->withPivot('scoreboard_a', 'scoreboard_b', 'result');
    }

    public function getScoreboardABettingAttribute()
    {
        $user = auth()->user();
        return $this->users()->find($user->id)->pivot->scoreboard_a ?? null;
    }

    public function getScoreboardBBettingAttribute()
    {
        $user = auth()->user();
        return $this->users()->find($user->id)->pivot->scoreboard_b ?? null;
    }

    public function getBettingAttribute()
    {
        $user = auth()->user();
        $teamA = $this->users()->find($user->id)->pivot->scoreboard_a ?? null;
        $teamB = $this->users()->find($user->id)->pivot->scoreboard_b ?? null;
        if ($teamA == '' && $teamB == '') {
            return "";
        }
        //dd($a);
        return "$teamA x $teamB";
        //return "";
    }

    public function getDateSiteAttribute()
    {
      $date = date_create($this->date);
      return date_format($date,'d/m/Y H:i:s');
    }

    public function getRoundTitleAttribute()
    {
      return $this->round->title.'-'.$this->round->betting_title;;
    }

    public function setDateAttribute($value)
    {
        $date = date_create(str_replace("/","-",$value));
        $this->attributes['date'] = date_format($date,'Y-m-d H:i:s');
    }
}
