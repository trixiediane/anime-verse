@extends('layouts.app')

<link href="{{ asset('css/getbootstrap.css') }}" rel="stylesheet">
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-10 mx-auto">
            <div class="card shadow-sm">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ $anime['images']['jpg']['large_image_url'] ?? '#' }}" class="img-fluid rounded-start"
                            alt="{{ $anime['title'] }}">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <!-- Move the button to the top right -->
                            <div class="float-md-end mb-3">
                                <a href="" class="card-link" data-toggle="modal" data-target="#favouriteModal">
                                    Add to Category
                                </a>
                            </div>
                            <h5 class="card-title mt-4">{{ $anime['title'] }}</h5>
                            <p class="card-text"><strong>Synopsis:</strong> {{ $anime['synopsis'] ?? 'N/A' }}</p>
                            <ul class="list-unstyled">
                                <li><strong>Type:</strong> {{ $anime['type'] ?? 'N/A' }}</li>
                                <li><strong>Status:</strong> {{ $anime['status'] ?? 'N/A' }}</li>
                                <li><strong>Aired:</strong> {{ $anime['aired']['string'] ?? 'N/A' }}</li>
                                <li><strong>Episodes:</strong> {{ $anime['episodes'] ?? 'N/A' }}</li>
                                <li><strong>Duration:</strong> {{ $anime['duration'] ?? 'N/A' }}</li>
                                <li><strong>Score:</strong> {{ $anime['score'] ?? 'N/A' }}</li>
                                <li><strong>Ranked:</strong> #{{ $anime['rank'] ?? 'N/A' }}</li>
                                <li><strong>Popularity:</strong> #{{ $anime['popularity'] ?? 'N/A' }}</li>
                                <li><strong>Members:</strong> {{ $anime['members'] ?? 'N/A' }}</li>
                                <li><strong>Favorites:</strong> {{ $anime['favorites'] ?? 'N/A' }}</li>
                                <li><strong>Genres:</strong>
                                    @foreach ($anime['genres'] ?? [] as $genre)
                                        <a href="{{ $genre['url'] }}"
                                            class="badge bg-primary">{{ $genre['name'] ?? 'N/A' }}</a>
                                    @endforeach
                                </li>
                                <li><strong>Producers:</strong>
                                    @foreach ($anime['producers'] ?? [] as $producer)
                                        <a href="{{ $producer['url'] }}"
                                            class="badge bg-secondary">{{ $producer['name'] ?? 'N/A' }}</a>
                                    @endforeach
                                </li>
                                <li><strong>Studios:</strong>
                                    @foreach ($anime['studios'] ?? [] as $studio)
                                        <a href="{{ $studio['url'] }}"
                                            class="badge bg-info">{{ $studio['name'] ?? 'N/A' }}</a>
                                    @endforeach
                                </li>
                                <li><strong>Licensors:</strong>
                                    @foreach ($anime['licensors'] ?? [] as $licensor)
                                        <a href="{{ $licensor['url'] }}"
                                            class="badge bg-success">{{ $licensor['name'] ?? 'N/A' }}</a>
                                    @endforeach
                                </li>
                                <li><strong>Watch on:</strong>
                                    @foreach ($anime['streaming'] ?? [] as $stream)
                                        <a href="{{ $stream['url'] }}"
                                            class="badge bg-warning">{{ $stream['name'] ?? 'N/A' }}</a>
                                    @endforeach
                                </li>
                            </ul>
                            <a href="{{ $anime['url'] ?? '#' }}" class="btn btn-primary">More Info</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="favouriteModal" tabindex="-1" role="dialog" aria-labelledby="favouriteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="favouriteModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Your Categories</label>
                    <select id="categoryOptions" class="form-select mb-3">
                        @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveAnime()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var id = user_data.id;

        function saveAnime() {
            let category_id = $('#categoryOptions').val();
            let anime_id = "{{ $anime['mal_id'] }}";
            let csrf = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: "POST",
                url: "{{ route('anime.store') }}",
                headers: {
                    "X-CSRF-TOKEN": csrf
                },
                data: {
                    category_id: category_id,
                    anime_id: anime_id
                },
                dataType: "json",
                success: function(response) {
                    // console.log("Success:", response);
                    if (response.status == 200) {
                        Swal.fire({
                            title: "Success",
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        })
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    }
                    $('#favouriteModal').trigger('click');
                },
                error: function(response) {
                    console.log("Error:", response);
                    Swal.fire({
                        title: "Error",
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                    $('#favouriteModal').trigger('click');
                }
            });
        }
    </script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
@endsection
