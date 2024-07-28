@extends('layouts.app')
@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Search Anime</h1>
            <a class="badge bg-dark text-white ms-2" href="https://myanimelist.net/">
                from MyAnimeList
            </a>
        </div>

        <div class="input-group d-flex justify-content-center align-items-center">
            <input id="animeInput" type="search" class="form-control rounded flex items-center justify-center"
                style="max-width:400px;" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
            <button onclick="searchAnime()" type="button" class="btn btn-outline-primary">search</button>
        </div>

        <!-- Anime Cards Row -->
        <div id="topAnimeRow" class="row">
        </div>
    </div>
    <script>
        function searchAnime() {
            $.ajax({
                url: "{{ route('anime.search') }}",
                type: 'GET',
                data: {
                    search: $('#animeInput').val(),
                },
                success: function(data) {
                    console.log("Data received: ", data); // Log the response to console

                    $("#topAnimeRow").empty();
                    data.data.forEach(anime => {
                        let genresHtml = anime.genres.map(genre => {
                            let randomBg = getRandomColor();
                            return `<a href="${genre.url}" class="badge ${randomBg} me-1 my-1">${genre.name}</a>`;
                        }).join('');

                        let animeUrl =
                            `/anime/show/${anime.mal_id}`; // Construct the URL for the anime show page

                        $("#topAnimeRow").append(`
                        <div class="col-12 col-md-3 col-sm-2 mt-4">
                            <div class="card h-100">
                                <img class="card-img-top" src="${anime.images.jpg.large_image_url}" alt="Anime Image">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">${anime.title}</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        ${genresHtml}
                                    </p>
                                </div>
                                <hr class="color-gray">
                                <div class="card-footer">
                                    <a href="${animeUrl}" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                    `);
                    });

                    // Random background color function
                    function getRandomColor() {
                        const colors = ['bg-primary', 'bg-secondary', 'bg-success', 'bg-danger',
                            'bg-warning', 'bg-info'
                        ];
                        return colors[Math.floor(Math.random() * colors.length)];
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error: ", error); // Log any errors to console
                    console.error("XHR: ", xhr); // Log the full XHR object
                    console.error("Status: ", status); // Log the status
                }
            });
        }
    </script>
@endsection
