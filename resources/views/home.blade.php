@extends('layouts.app')

@section('content')
    {{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> --}}

    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Top Anime</h1>
            <a class="badge bg-dark text-white ms-2" href="upgrade-to-pro.html">
                from MyAnimeList
            </a>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card">
                    <img class="card-img-top" src="img/photos/unsplash-2.jpg" alt="Unsplash">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Card with image and button</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                            card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <img class="card-img-top" src="img/photos/unsplash-2.jpg" alt="Unsplash">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Card with image and button</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                            card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <img class="card-img-top" src="img/photos/unsplash-2.jpg" alt="Unsplash">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Card with image and button</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                            card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <img class="card-img-top" src="img/photos/unsplash-2.jpg" alt="Unsplash">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Card with image and button</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                            card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <img class="card-img-top" src="img/photos/unsplash-2.jpg" alt="Unsplash">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Card with image and button</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                            card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <img class="card-img-top" src="img/photos/unsplash-2.jpg" alt="Unsplash">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Card with image and button</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                            card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
