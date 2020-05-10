<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\MatchRepositoryInterface;
use Validator;
use App\Round;
use DateTime;





class MatchController extends Controller
{

    private $route = 'matches';
    private $paginate = 10;
    private $search = ['title','stadium','team_a','team_b',''];
    private $model;

    public function __construct(MatchRepositoryInterface $model)
    {

        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columnList = ['id'=>'#',
          'title'=>trans('bolao.title'),
          'round_title'=>trans('bolao.round'),
          'stadium'=>trans('bolao.stadium'),
          'team_a'=>trans('bolao.team_a'),
          'team_b'=>trans('bolao.team_b'),
          'result'=>trans('bolao.result'),
          'scoreboard_a'=>trans('bolao.scoreboard_a'),
          'scoreboard_b'=>trans('bolao.scoreboard_b'),
          'date_site' => trans('bolao.date')
          
           
        ];
        $page = trans('bolao.match_list');

        $search = "";
        if(isset($request->search)){
          $search = $request->search;
          $list = $this->model->findWhereLike($this->search,$search,'id','DESC');
        }else{
          $list = $this->model->paginate($this->paginate,'id','DESC');
        }

        $routeName = $this->route;

        //session()->flash('msg', 'Olá Alert');
        //session()->flash('status', 'success'); // success error notification

        $breadcrumb = [
          (object)['url'=>route('home'),'title'=>trans('bolao.home')],
          (object)['url'=>'','title'=>trans('bolao.list',['page'=>$page])],
        ];

        return view('admin.'.$routeName.'.index',compact('list','search','page','routeName','columnList','breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $routeName = $this->route;
        $page = trans('bolao.match_list');
        $page_create = trans('bolao.match');

        $user = auth()->user();
        $listRel = $user->rounds;

        $breadcrumb = [
          (object)['url'=>route('home'),'title'=>trans('bolao.home')],
          (object)['url'=>route($routeName.".index"),'title'=>trans('bolao.list',['page'=>$page])],
          (object)['url'=>'','title'=>trans('bolao.create_crud',['page'=>$page_create])],
        ];

        return view('admin.'.$routeName.'.create',compact('page','page_create','routeName','breadcrumb','listRel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $date_end= Round::find($data['round_id']);
        $data['date_end'] = new DateTime($date_end->date_end);
        $timestamp = strtotime(str_replace('/', '-', $data['date']));
        $data['date'] = new DateTime(date('Y-m-d H:i:s',$timestamp));
        Validator::make($data, [
          'title' => 'required|string|max:255',
          'stadium' => 'required',
          'team_a' => 'required',
          'team_b' => 'required',
          'result' => 'required',
          'scoreboard_a' => 'required',
          'scoreboard_b' => 'required',
          'date' => 'required|after:date_end',

        ])->validate();
        $data['date'] = $data['date']->format('d/m/Y H:i:s');
        array_pop($data);
        if($this->model->create($data)){
          session()->flash('msg', trans('bolao.record_added_successfully'));
          session()->flash('status', 'success'); // success error notification
          return redirect()->back();
        }else{
          session()->flash('msg', trans('bolao.error_adding_registry'));
          session()->flash('status', 'error'); // success error notification
          return redirect()->back();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
      $routeName = $this->route;
      $register = $this->model->find($id);
      if($register){
        $page = trans('bolao.match_list');
        $page2 = trans('bolao.match');

        $breadcrumb = [
          (object)['url'=>route('home'),'title'=>trans('bolao.home')],
          (object)['url'=>route($routeName.".index"),'title'=>trans('bolao.list',['page'=>$page])],
          (object)['url'=>'','title'=>trans('bolao.show_crud',['page'=>$page2])],
        ];
        $delete = false;
        if($request->delete ?? false){
          session()->flash('msg', trans('bolao.delete_this_record'));
          session()->flash('status', 'notification'); // success error notification
          $delete = true;
        }

        return view('admin.'.$routeName.'.show',compact('register','page','page2','routeName','breadcrumb','delete'));

      }

      return redirect()->route($routeName.'.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $routeName = $this->route;
        $register = $this->model->find($id);

        if($register){
          $page = trans('bolao.match_list');
          $page2 = trans('bolao.match');

          $user = auth()->user();
          $listRel = $user->rounds;
          $register_id = $register->round_id;
          
          $breadcrumb = [
            (object)['url'=>route('home'),'title'=>trans('bolao.home')],
            (object)['url'=>route($routeName.".index"),'title'=>trans('bolao.list',['page'=>$page])],
            (object)['url'=>'','title'=>trans('bolao.edit_crud',['page'=>$page2])],
          ];

          return view('admin.'.$routeName.'.edit',compact('register','page','page2','routeName','breadcrumb','listRel','register_id'));

        }

        return redirect()->route($routeName.'.index');


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $date_end= Round::find($data['round_id']);
        $data['date_end'] = new DateTime($date_end->date_end);
        $timestamp = strtotime(str_replace('/', '-', $data['date']));
        $data['date'] = new DateTime(date('Y-m-d H:i:s',$timestamp));
        Validator::make($data, [
          'title' => 'required|string|max:255',
          'stadium' => 'required',
          'team_a' => 'required',
          'team_b' => 'required',
          'result' => 'required',
          'scoreboard_a' => 'required',
          'scoreboard_b' => 'required',
          'date' => 'required|after:date_end',
        ])->validate();
        $data['date'] = $data['date']->format('d/m/Y H:i:s');
        array_pop($data);  
        if($this->model->update($data,$id)){
          session()->flash('msg', trans('bolao.successfully_edited_record'));
          session()->flash('status', 'success'); // success error notification
          return redirect()->back();
        }else{
          session()->flash('msg', trans('bolao.error_editing_record'));
          session()->flash('status', 'error'); // success error notification
          return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->model->delete($id)){
          session()->flash('msg', trans('bolao.registration_deleted_successfully'));
          session()->flash('status', 'success'); // success error notification
        }else{
          session()->flash('msg', trans('bolao.error_deleting_record'));
          session()->flash('status', 'error'); // success error notification
        }
        $routeName = $this->route;
        return redirect()->route($routeName.'.index');
    }
}
