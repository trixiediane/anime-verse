@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Top Anime</h1>
            <a class="badge bg-dark text-white ms-2" href="https://myanimelist.net/">
                from MyAnimeList
            </a>
        </div>

        <!-- Filters -->
        <div class="row">
            <div class="col-12 col-md-3 mb-3">
                <label for="typeFilter" class="form-label">Type:</label>
                <select id="typeFilter" class="form-select">
                    <option value="">All</option>
                    <option value="tv">TV</option>
                    <option value="movie">Movie</option>
                    <option value="ova">OVA</option>
                    <!-- Add other options as needed -->
                </select>
            </div>
            <div class="col-12 col-md-3 mb-3">
                <label for="filterFilter" class="form-label">Filter:</label>
                <select id="filterFilter" class="form-select">
                    <option value="">All</option>
                    <option value="airing">Airing</option>
                    <option value="upcoming">Upcoming</option>
                    <option value="bypopularity">By Popularity</option>
                    <option value="favorite">Favorite</option>
                    <!-- Add other options as needed -->
                </select>
            </div>
            <div class="col-12 col-md-3 mb-3">
                <label for="ratingFilter" class="form-label">Rating:</label>
                <select id="ratingFilter" class="form-select">
                    <option value="">All</option>
                    <option value="g">G - All Ages</option>
                    <option value="pg">PG - Children</option>
                    <option value="pg13">PG-13 - Teens 13 or older</option>
                    <option value="r17">R - 17+ (violence & profanity)</option>
                    <option value="r">R+ - Mild Nudity</option>
                    <option value="rx">Rx - Hentai</option>
                    <!-- Add other options as needed -->
                </select>
            </div>
            <div class="col-12 col-md-3 mb-3">
                <label for="limitSelect" class="form-label">Results Per Page:</label>
                <select id="limitSelect" class="form-select">
                    <option value="10">10</option>
                    <option value="25">25</option>
                </select>
            </div>
            <div class="col-12 col-md-3 mb-3">
                <input type="checkbox" class="form-check-input" id="sfwFilter">
                <label class="form-check-label" for="sfwFilter">SFW Only</label>
            </div>

        </div>

        <!-- Anime Cards Row -->
        <div id="topAnimeRow" class="row">
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Function to fetch top anime data based on filters
            function fetchTopAnime() {
                $.ajax({
                    url: '/top-anime',
                    type: 'GET',
                    data: {
                        type: $('#typeFilter').val(),
                        filter: $('#filterFilter').val(),
                        rating: $('#ratingFilter').val(),
                        sfw: $('#sfwFilter').prop('checked'),
                        page: 1, // Example: Always fetch first page for simplicity
                        limit: $('#limitSelect').val(),
                    },
                    success: function(data) {
                        console.log("Data received: ", data); // Log the response to console
                        // Handle the data as needed

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

            // Initial fetch on page load
            fetchTopAnime();

            // Event listeners for filter changes
            $('#typeFilter, #filterFilter, #ratingFilter, #sfwFilter, #limitSelect').change(function() {
                fetchTopAnime(); // Fetch anime data when any filter changes
            });
        });
    </script>
@endsection
