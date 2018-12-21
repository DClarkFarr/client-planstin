@extends('layouts.app')

@section('header')

    {{--<div class="wrapper">--}}

    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container border-btm">
                <a class="navbar-brand" href="#"><img class="head-logo" src="{{asset('images/head-logo.png')}}" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav navbar-right">
                        <li class="nav-item active">
                            <a class="nav-link text-red" href="#"><i class="fa fa-home" aria-hidden="true"></i>
                                <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-red" href="#"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

@endsection

@section('sidebar')

    <!-- side bar -->
    <div class="sidebar bg-sidebar">

        <div class="pro-img-container">
            <div class="img-cir">
                <img class="profile-img" src="/images/ManSmile-300x215.png" alt="profile image">
            </div>
            <h2 class="p-name">Damon Andrews</h2>
            <h3 class="p-title">Manager</h3>
        </div>

        <a href="#" class="text-black edit-pro secure-m"><img src="/images/mail-icon.png" alt=""><span>Secure Email</span></a>

        <a href="#" class="text-black edit-pro"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span>Edit Profile</span></a>

    </div>

@endsection

@section('footer')
    <!--footer started-->
    <section class="footer">
        <footer class="bg-gray-4">
            <p class="footer-text text-white no-mgr-bottom">All Rights Reserved 2018 Planstin, Inc.</p>
        </footer>
    </section>
    <!--footer end-->
@endsection

@section('container')

    <div class="row">
        
        <div class="col-lg-9 order-lg-2">
            @yield('content')
        </div>
        <div class="col-lg-3 mt-5 mt-lg-0 order-lg-1">
            @yield('sidebar')
        </div>
    </div>


    <!-- <hr class="btm-bdr">

    <div class="push"></div> -->

@endsection
