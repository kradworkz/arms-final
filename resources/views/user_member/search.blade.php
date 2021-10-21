@extends('layouts.whole')
@section('content')
     
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Search Asset</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">{{Auth::user()->member->mm->member->name}} - {{Auth::user()->member->mm->municipality->name}}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <search :user="'{{ auth()->user()->type }}'"></search>
@endsection