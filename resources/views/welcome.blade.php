@extends('layouts.default')

@section('content')
    <!-- Intro Header -->
    <header class="intro">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="brand-heading">Challenge</h1>
                        <p class="intro-text">Code Something Awesome.
                            <br>We &lt;3 PHP Developers.</p>
                        <a href="#about" class="btn btn-circle page-scroll">
                            <i class="fa fa-angle-double-down animated"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>About This Challenge</h2>
                <p>We make awesome things at Dealer Inspire. We'd like you to join us. That's why we made this page. Are
                    you
                    ready to join the team?</p>
                <p>To take the code challenge, visit <a href="https://bitbucket.org/dealerinspire/php-contact-form">this
                        Git
                        Repo</a> to clone it and start your work.</p>
            </div>
        </div>
    </section>

    <section id="coffee" class="content-section text-center">
        <div class="download-section">
            <div class="container">
                <div class="col-lg-8 col-lg-offset-2">
                    <h2>Coffee Break?</h2>
                    <p>Take a coffee break. You deserve it.</p>
                    <a href="https://www.youtube.com/dealerinspire" class="btn btn-default btn-lg">or Watch YouTube</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>Contact Guy Smiley</h2>
                <p>Remember Guy Smiley? Yeah, he wants to hear from you.</p>

                <div id="form_anchor"
                     class="text-left col-lg-10 col-lg-offset-1 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                    <form method="POST" action="{{ route('contact', '#form_anchor') }}" class="contact-form" novalidate>
                        @csrf

                        <div class="form-group">
                            <label for="full_name">Full Name *</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                   name="full_name"
                                   id="full_name" value="{{old('full_name')}}">
                            <div class="text-danger">
                                @error('full_name') {{ $message }} @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                   id="email" value="{{old('email')}}">
                            <div class="text-danger">
                                @error('email') {{ $message }} @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                   id="phone" value="{{old('phone')}}">
                            <div class="text-danger">
                                @error('phone') {{ $message }} @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" name="message"
                                      id="message" rows="10">{{old('message')}}</textarea>
                            <div class="text-danger">
                                @error('message') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default btn-block">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <div id="map"></div>

@endsection
