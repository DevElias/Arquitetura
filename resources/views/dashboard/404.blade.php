@extends('layouts.master')
@section('main-content')

<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-12 text-center">

    <h1>404 - Página não encontrada</h1>
    </div>

</div>

@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>

@endsection
