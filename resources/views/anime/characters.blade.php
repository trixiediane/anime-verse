@extends('layouts.app')
@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Search Anime Characters</h1>
            <a class="badge bg-dark text-white ms-2" href="https://myanimelist.net/">
                from MyAnimeList
            </a>
        </div>

        <div class="input-group d-flex justify-content-center align-items-center">
            <input id="animeInput" type="search" class="form-control rounded flex items-center justify-center"
                style="max-width:400px;" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
            <button onclick="searchCharacter()" type="button" class="btn btn-outline-primary">search</button>
        </div>

        <div class="container my-4">
            <ul id="animeList" class="list-group my-4">

            </ul>
        </div>

    </div>
    <script>
        function searchCharacter() {
            $.ajax({
                url: "{{ route('anime.characters') }}",
                type: 'GET',
                data: {
                    search: $('#animeInput').val(),
                },
                success: function(data) {
                    console.log("Data received: ", data); // Log the response to console

                    // Clear existing list items
                    $('#animeList').empty();

                    // Iterate over the data and append each character
                    data.data.forEach(character => {
                        const listItem = `
                    <li class="list-group-item d-flex align-items-start">
                        <img src="${character.images.webp.small_image_url}" class="rounded me-3" alt="${character.name}" style="width: 50px;">
                        <div class="flex-grow-1">
                            <h5 class="mb-1"><a href="${character.url}">${character.name}</a></h5>
                            ${character.name_kanji ? `<p class="mb-1"><small>Kanji: ${character.name_kanji}</small></p>` : ''}
                            ${character.about ? `<p class="mb-1">${character.about}</p>` : ''}
                            <span class="badge bg-primary">Favorites: ${character.favorites}</span>
                        </div>
                    </li>
                `;
                        $('#animeList').append(listItem);
                    });

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
