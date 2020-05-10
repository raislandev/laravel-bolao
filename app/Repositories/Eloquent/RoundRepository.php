<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\RoundRepositoryInterface;
use App\Round;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;

class RoundRepository extends AbstractRepository implements RoundRepositoryInterface
{
    protected $model = Round::class;


    public function paginate(int $paginate = 10, string $column = 'id', string $order = 'ASC'):LengthAwarePaginator
    {
        if (Gate::denies('manage-bets')) {
            $user = auth()->user();

            return $this->model->whereIn('betting_id', [$user->bettings()->value('id')] ?? [])->orderBy($column,$order)->paginate($paginate);
        }

        return $this->model->orderBy($column,$order)->paginate($paginate);
    }

    public function findWhereLike(array $columns, string $search, string $column = 'id', string $order = 'ASC'):Collection
    {
        $query = $this->model;

        if (Gate::denies('manage-bets')) {
            $user = auth()->user();
            foreach ($columns as $key => $value) {
                $query = $query->orWhere($value,'like','%'.$search.'%');
            }

            return $query->whereIn('betting_id', [$user->bettings()->value('id')] ?? [])->orderBy($column,$order)->get();
        }

        foreach ($columns as $key => $value) {
            $query = $query->orWhere($value,'like','%'.$search.'%');
        }

        return $query->orderBy($column,$order)->get();
    }

    public function create(array $data):Bool
    {

      $user = auth()->user();
      $listRel = $user->bettings;
      $betting_id = $data['betting_id'];
      $exist = false;

      foreach($listRel as $key => $value){
         if($betting_id == $value->id){
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
        if (Gate::denies('manage-bets')) {
          $register = $this->find($id);
          if($register){
              $user = auth()->user();
              $listRel = $user->bettings;
              $betting_id = $data['betting_id'];
              $exist = false;

              foreach ($listRel as $key => $value) {
                  if($betting_id == $value->id){
                      $exist = true;
                  }
              }
              if($exist){
                  return (bool) $register->update($data);
              }else{
                  return false;
              }

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




}
