<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\BettingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Betting;
use App\Round;
use Illuminate\Support\Facades\Gate;

class BettingRepository extends AbstractRepository implements BettingRepositoryInterface
{
    protected $model = Betting::class;


   public function list(){
      $list = Betting::all();
      $user = Auth()->user();
      if($user){
        $myBetting = $user->myBetting;
        foreach($list as $key => $value){
          if($myBetting->contains($value)){
            $value->subscriber = true;
            //dd($value);
          }
        }
      }
      return $list;
   }


   public function paginate(int $paginate = 10, string $column = 'id', string $order = 'ASC'):LengthAwarePaginator
    {
        if (Gate::denies('manage-bets')) {
            return $this->model->where('user_id', '=', auth()->user()->id)->orderBy($column,$order)->paginate($paginate);
        }

        return $this->model->orderBy($column,$order)->paginate($paginate);
    }

    public function findWhereLike(array $columns, string $search, string $column = 'id', string $order = 'ASC'):Collection
    {
        $query = $this->model;

        if (Gate::denies('manage-bets')) {
            foreach ($columns as $key => $value) {
                $query = $query->orWhere($value,'like','%'.$search.'%');
            }

            return $query->where('user_id', '=', auth()->user()->id)->orderBy($column,$order)->get();
        }

        foreach ($columns as $key => $value) {
            $query = $query->orWhere($value,'like','%'.$search.'%');
        }

        return $query->orderBy($column,$order)->get();
    }


    public function create(array $data):Bool
    {
        $user = Auth()->user();
        $data['user_id'] = $user->id;
        return (bool) $this->model->create($data);
    }

    public function update(array $data, int $id):Bool
    {
        if (Gate::denies('manage-bets')) {
          $register = $this->find($id);
          if($register){
              $user = Auth()->user();
              $data['user_id'] = $user->id;
              return (bool) $register->update($data);
          }else{
              return false;
          }
        } 

        $register = $this->find($id);
        if($register){
          return (bool) $register->update($data);
        }else{
          return false;
        }
    }


    public function BettingUser($id){
      $user = Auth()->user();
      $betting = Betting::find($id);

      //toggle cria um relacionamento se não existir, e se existir ele remove
      if($betting){
        $res = $user->myBetting()->toggle($betting->id);
        if(count($res['attached'])){
          return true;
        }
      }

      return false;
    }


    public function rounds($betting_id){
      $user = Auth()->user();
      $betting = $user->myBetting()->find($betting_id);

      if($betting){
        return $betting->rounds()->orderBy('date_start','desc')->get();
      }

      return false;
    }


  public function findBetting($round_id){
    $round = Round::find($round_id);
    if($round){
      return $round->betting;
    }
    return false;
  }

  public function matches($round_id) {
    $user = Auth()->user();
    $round = Round::find($round_id);
    if (!$round) {
       return false;
    }
    $betting_id = $round->betting->id;
    $betting = $user->myBetting()->find($betting_id);
    if($betting){
        return $round->matches()->orderBy('date', 'desc')->get();
    }
    return false;
  }

  public function classification($betting_id) {
    $betting = Betting::find($betting_id);
    $bettors = $betting->bettors()->orderBy('pivot_points', 'DESC')->get();
    //dd($bettors);

    return $bettors;
  }
  


}
