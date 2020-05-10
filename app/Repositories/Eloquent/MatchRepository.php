<?php

namespace App\Repositories\Eloquent;

use App\MatchUser;
use App\Repositories\Contracts\MatchRepositoryInterface;
use App\Match;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;


class MatchRepository extends AbstractRepository implements MatchRepositoryInterface
{
    protected $model = Match::class;



    public function paginate(int $paginate = 10, string $column = 'id', string $order = 'ASC'):LengthAwarePaginator
    {
        if (Gate::denies('manage-bets')) {
            $user = auth()->user();
            $list = [];
            foreach ($user->bettings as $betting){
                foreach ($betting->rounds as $round) {
                    $list[] = $round->matches()->value('id');
                }
            }

            return $this->model->whereIn('id', $list)->orderBy($column,$order)->paginate($paginate);
        }

        return $this->model->orderBy($column,$order)->paginate($paginate);
    }

    public function findWhereLike(array $columns, string $search, string $column = 'id', string $order = 'ASC'):Collection
    {
        $query = $this->model;

        if (Gate::denies('manage-bets')) {
            $user = auth()->user();
            $list = [];
            foreach ($user->bettings as $betting){
                foreach ($betting->rounds as $round) {
                    $list[] = $round->matches()->value('id');
                }
            }
            foreach ($columns as $key => $value) {
                $query = $query->orWhere($value,'like','%'.$search.'%');
            }

            return $query->whereIn('round_id', $list)->orderBy($column,$order)->get();
        }

        foreach ($columns as $key => $value) {
            $query = $query->orWhere($value,'like','%'.$search.'%');
        }

        return $query->orderBy($column,$order)->get();
    }
    

    public function create(array $data):Bool
    {

      $user = auth()->user();
      $listRel = $user->rounds;
      $round_id = $data['round_id'];
      $exist = false;

      foreach($listRel as $key => $value){
         if($round_id == $value->id){
           $exist = true;
         }
      }

      if($exist){
        //dd($data);
        return (bool) $this->model->create($data);
       
      }else{
        return false;
      }

    }

    public function update(array $data, int $id):Bool
    {
        $register = $this->find($id);
        if($register){
          $user = auth()->user();
          $listRel = $user->rounds;
          $round_id = $data['round_id'];
          $exist = false;
    
          foreach($listRel as $key =>$value){
             if($round_id == $value->id){
               $exist = true;
             }
          }
          if($exist){
            $this->calculatePoints($register);
            return (bool) $register->update($data);
          }else{
            return false;
          }
         
        }else{
          return false;
        }
    }



    public function calculatePoints($match)
    {
        $betting = $match->round->betting;
        $bettors = $betting->bettors;
        $now = now();
        foreach ($bettors as $user) {
            $taxa = 0;
            $pontos = 0;
            $roundTitle = '';
            foreach ($betting->rounds as $key => $roundValue) {
                if ($roundValue->date_end < $now ) {
                    $roundTitle = $roundValue->title;
                    foreach ($roundValue->matches as $matchValue) {
                      if ($roundValue->date_end < $now ) {
                        $roundTitle = $roundValue->title;
                        foreach ($roundValue->matches as $matchValue) {
                            if ($user->matches->contains($matchValue)) {
                                $bet = $user->matches()->find($matchValue->id);
                                $pontos += $bet->result === $bet->pivot->result ? $betting->value_result + $taxa : 0;
                                $pontos += $bet->scoreboard_a === $bet->pivot->scoreboard_a &&
                                    $bet->scoreboard_b === $bet->pivot->scoreboard_b ? $betting->extra_value + $taxa : 0;
                            }
                        }
                      }
                    }
                }

                $taxa += $betting->value_fee;
            }

            //$betting->current_round = $roundTitle;
            $betting->save();

            $user->myBetting()->updateExistingPivot(
                $betting,
                [
                    'points' => $pontos
                ]
            );
        }
    }



    public function match($match_id)
    {
        $user = auth()->user();
        $match = $user->matches()->find($match_id);
        //dd($user->matches);
        if ($match) {
           return $match;
        }

        $match = Match::find($match_id);
        $betting_id = $match->round->betting->id;
        $betting = $user->myBetting()->find($betting_id);
        if($betting){
            return $match;
        }

        return false;
    }

    public function MatchUserSave($match_id, $register)
    {
        $user = auth()->user();
        $match = $user->matches()->find($match_id);
        if (!$match) {
            $match = Match::find($match_id);
        }
        $betting_id = $match->round->betting->id;
        $betting = $user->myBetting()->find($betting_id);
        if($betting){
            $result = '';
            if($register['scoreboard_a']> $register['scoreboard_b']){
               $result = 'A';
            }else if($register['scoreboard_a'] === $register['scoreboard_b']){
              $result = 'E';
            }else{
               $result = 'B';
            }
            /*$result = $register['scoreboard_a']> $register['scoreboard_b'] ? 'A' :
                $register['scoreboard_a'] === $register['scoreboard_b'] ? 'E' : 'B';*/

            $ret = $match->users()->updateExistingPivot(
                $user->id,
                ['result' => $result, 'scoreboard_a' => $register['scoreboard_a'], 'scoreboard_b' => $register['scoreboard_b']]
            );
            if ($ret) {
                return $match;
            } else {
                $ret = MatchUser::updateOrCreate(
                    ['user_id' => $user->id, 'match_id' => $match->id],
                    ['result' => $result, 'scoreboard_a' => $register['scoreboard_a'], 'scoreboard_b' => $register['scoreboard_b']]
                );

                if ($ret) {
                    return $match;
                }
            }
        }

        return false;
    }




}
