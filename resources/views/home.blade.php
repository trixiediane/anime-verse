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
        <div id="topAnimeRow" class="row">
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/top-anime',
                type: 'GET',
                success: function(data) {
                    console.log("Data received: ", data); // Log the response to console
                    // Handle the data as needed

                    $("#topAnimeRow").empty();
                    data.data.forEach(anime => {
                        let synopsis = anime.synopsis;
                        const maxLength =
                        100; // Define the max length of the synopsis to display initially

                        if (synopsis.length > maxLength) {
                            let shortSynopsis = synopsis.substring(0, maxLength) + '...';
                            synopsis = `
                        <span class="short-synopsis">${shortSynopsis}</span>
                        <span class="full-synopsis" style="display:none;">${synopsis}</span>
                        <a href="#" class="read-more">Read more</a>`;
                        }

                        $("#topAnimeRow").append(`
                    <div class="col-12 col-md-3">
                        <div class="card">
                            <img class="card-img-top" src="${anime.images.jpg.large_image_url}" alt="Anime Image">
                            <div class="card-header">
                                <h5 class="card-title mb-0">${anime.title}</h5>
                            </div>
                            <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                                <p class="card-text">${synopsis}</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                `);
                    });

                    // Add event listener for "Read more" links
                    $(document).on('click', '.read-more', function(e) {
                        e.preventDefault();
                        $(this).siblings('.short-synopsis').hide();
                        $(this).siblings('.full-synopsis').show();
                        $(this).parent().css('max-height',
                        'none'); // Remove max-height to allow full display
                        $(this).hide(); // Hide the "Read more" link
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error: ", error); // Log any errors to console
                    console.error("XHR: ", xhr); // Log the full XHR object
                    console.error("Status: ", status); // Log the status
                }
            });
        });
    </script>
@endsection
