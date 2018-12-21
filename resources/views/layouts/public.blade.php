@extends('layouts.app')

@section('header')

    {{--<div class="wrapper">--}}

    <!-- header start -->
    <header>
        <nav class="navbar navbar-expand-lg bg-head-gray">
            <div class="container">
                <a class="navbar-brand" href="#"><img class="head-logo" src="{{asset('images/head-logo.png')}}" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav navbar-right">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Main <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About US</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Benefits</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- header end -->

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
    @yield('content')
@endsection
