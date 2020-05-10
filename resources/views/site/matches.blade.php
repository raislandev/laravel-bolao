@extends('layouts.app')

@section('content')
    @page_component(['col'=>12, 'page'=>__('bolao.list',['page'=>$page])])

          @alert_component(['msg'=>session('msg'), 'status'=>session('status')])
          @endalert_component

          @breadcrumb_component(['page'=>$page,'items'=>$breadcrumb ?? []])
          @endbreadcrumb_component

          @table_site_component(['columnList'=>$columnList,'list'=>$list, 'routeName'=>$routeName])
          @endtable_site_component

    @endpage_component
@endsection
