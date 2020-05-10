<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\BettingRepositoryInterface;
use App\Repositories\Contracts\MatchRepositoryInterface;
use DateTime;



class PrincipalController extends Controller
{

    public function index(BettingRepositoryInterface $bettingRepository)
    {
       $list = $bettingRepository->list();
       return view('site.index',compact('list'));
    }

    public function signNoLogin($id){
        return redirect()->route('principal');
    }


    public function sign($id, BettingRepositoryInterface $bettingRepository)
    {

        $bettingRepository->BettingUser($id);
        return redirect(route('principal').'#portfolio');
    }


    public function rounds($betting_id, BettingRepositoryInterface $bettingRepository)
    {
        
        $columnList = ['id'=>'#',
          'title'=>trans('bolao.title'),
          'betting_title'=>trans('bolao.bet'),
          'date_start_site'=>trans('bolao.date_start'),
          'date_end_site'=>trans('bolao.date_end')
        ];
        $betting = $bettingRepository->find($betting_id);
        $page = trans('bolao.round_list')." ($betting->title)";
        $routeName='rounds.matches';

        $search = "";
        $list = $bettingRepository->rounds($betting_id);
        if(!$list){
            return redirect(route('principal').'#portfolio');
        }

        //session()->flash('msg', 'Olá Alert');
        //session()->flash('status', 'success'); // success error notification

        $breadcrumb = [
          (object)['url'=>route('principal').'#portfolio','title'=>trans('bolao.betting_list')],
          (object)['url'=>'','title'=>trans('bolao.list',['page'=>$page])],
        ];

        return view('site.rounds',compact('list','page','columnList','breadcrumb','routeName'));
    }


    public function matches($round_id, BettingRepositoryInterface $bettingRepository)
    {
        $list = $bettingRepository->matches($round_id);
        if (!$list) {
            return redirect()->route('principal');
        }
        if(new DateTime() < new DateTime($list[0]->round->date_start) || new DateTime() > new DateTime($list[0]->round->date_end)){
            return redirect()->route('rounds',$list[0]->round->betting->id);
        }
        $betting = $bettingRepository->findBetting($round_id);
        $page = trans('bolao.match_list');
        $routeName = "match.result";
        $columnList = ['id'=>'#',
          'title'=>trans('bolao.title'),
          'round_title'=>trans('bolao.round'),
          'stadium'=>trans('bolao.stadium'),
          'date_site'=>trans('bolao.date'),
          'betting'=>trans('bolao.bet'),
        ];
        $breadcrumb = [
          (object)['url'=>route('principal').'#portfolio','title'=>trans('bolao.betting_list')],
          (object)['url'=>route('rounds', $betting->id),'title'=>trans('bolao.round_list')." ($betting->title)"],
          (object)['url'=>'','title'=>trans('bolao.list',['page'=>$page])],
        ];
        
        //dd($list);

        return view('site.matches',compact('list','page','columnList','breadcrumb','routeName'));

    }

    

    public function result($match_id, MatchRepositoryInterface $matchRepository, BettingRepositoryInterface $bettingRepository){
        $register = $matchRepository->match($match_id);
        if (!$register) {
            return redirect()->route('principal');
        }
        if(new DateTime() < new DateTime($register->round->date_start) || new DateTime() > new DateTime($register->round->date_end)){
            return redirect()->route('rounds',$register->round->betting->id);
        }
        $routeName = "match.result";
        $betting = $bettingRepository->findBetting($register->round->id);
        $page = trans('bolao.bet');
        //dd($register->round->id);
        $breadcrumb = [
              (object)['url'=>route('principal').'#portfolio','title'=>trans('bolao.betting_list')],
              (object)['url'=>route('rounds', $betting->id),'title'=>trans('bolao.round_list')." ($betting->title)"],
              (object)['url'=>route('rounds.matches', $register->round->id),'title'=>trans('bolao.list',['page'=>trans('bolao.match_list')])],
              (object)['url'=>'','title'=>$page],
        ];
        //dd($register);
        return view('site.betting',compact('register','page','breadcrumb','routeName'));

    }


    public function update($match_id, Request $request, MatchRepositoryInterface $matchRepository)
    {
        $data = $request->all();
        // validação ...
        if($match = $matchRepository->MatchUserSave($match_id, $data)){
            session()->flash('msg', trans('bolao.successfully_edited_record'));
            session()->flash('status', 'success'); // success error notification
            return redirect()->route('rounds.matches', $match->round->id);
        } else {
            session()->flash('msg', trans('bolao.error_editing_record'));
            session()->flash('status', 'error'); // success error notification
            return redirect()->back();
        }
    }

    public function classification($betting_id, BettingRepositoryInterface $bettingRepository)
    {
        $columnList = ['OrderAsc'=>'#',
            'name'=>trans('bolao.name'),
            'pivot_points'=>trans('bolao.points')
        ];

        $betting = $bettingRepository->find($betting_id);
        $page = trans('bolao.classification');

        $list = $bettingRepository->classification($betting_id);
        $routeName = "principal";
        if (!$list) {
            return redirect(route('principal').'#portfolio');
        }

        $breadcrumb = [
            (object)['url'=>route('principal').'#portfolio','title'=>trans('bolao.betting_list')],
            (object)['url'=>'','title'=>trans('bolao.list',['page'=>$page])],
        ];

    
        return view('site.classification',compact('list','page','columnList','breadcrumb','routeName'));
    }
  

   
}
