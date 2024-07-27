@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-9 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <h5 class="card-title mb-0">List of Anime</h5>
                </div>
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Actions</th> <!-- Only Name and Actions columns -->
                        </tr>
                    </thead>
                    <tbody id="animeTableBody">
                        <!-- Table rows will be appended here dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        var categoryId = "{{ $categoryId }}";
        console.log(categoryId);
        animeList();

        function animeList() {
            var csrf = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('anime.user-list') }}",
                method: "GET",
                dataType: "json",
                data: {
                    category_id: categoryId
                },
                success: function(response) {
                    console.log(response);

                    // Clear existing table rows
                    $('#animeTableBody').empty();
                    var animeShowUrl = "{{ route('anime.show', ['id' => 'id']) }}";
                    // Populate table with anime data
                    response.forEach(function(anime) {
                        var detailUrl = animeShowUrl.replace('id', anime.mal_id);
                        var row = `
                            <tr>
                                <td>
                                    <a href="${detailUrl}">
                                        ${anime.title}
                                    </a>
                                </td>
                                <td class="d-flex align-items-center gap-3">
                                    <a href="#" class="text-blue-500 hover:underline" onclick="updateAnime(${anime.mal_id})">
                                       Update
                                    </a>
                                    <a href="#" class="text-red-500 hover:underline ml-2" onclick="removeAnime(${anime.mal_id})">
                                       Remove
                                    </a>
                                </td>
                            </tr>`;
                        $('#animeTableBody').append(row);
                    });
                },
                error: function(response) {
                    console.log("error");
                    console.log(response);
                    Swal.fire({
                        title: "Error",
                        text: response.text,
                        icon: 'error',
                        confirmButtonText: 'Ok',
                    });
                }
            });
        }

        function updateAnime(mal_id) {
            // Handle anime update logic
            console.log('Update anime with mal_id:', mal_id);
        }

        function removeAnime(mal_id) {
            // Handle anime removal logic
            console.log('Remove anime with mal_id:', mal_id);
        }
    </script>
@endsection
