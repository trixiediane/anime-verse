@extends('layouts.app')

<link href="{{ asset('css/getbootstrap.css') }}" rel="stylesheet">
@section('content')
    <div class="flex flex-col lg:flex-row gap-4 p-4">
        <!-- Card Section -->
        <div class="w-full lg:w-1/4 bg-white shadow-md rounded-lg">
            <div class="p-4">
                <h5 class="text-lg font-semibold">{{ $category->name }}</h5>
                <hr class="my-4">
                <p class="text-gray-700 mb-4">{{ $category->description }}</p>
            </div>
            <div class="flex justify-between px-4 border-t border-gray-200 bg-gray-50">
                <div class="flex-1 text-left">
                    <a href="#" class="text-blue-500 hover:text-blue-700">Update Category</a>
                </div>
                <div class="flex-1 text-right">
                    <a href="#" class="text-blue-500 hover:text-blue-700">Delete this Category</a>
                </div>
            </div>
        </div>

        <!-- Anime Table Section -->
        <div class="flex-1 lg:w-3/4">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                {{-- <div class="p-4 border-b border-gray-200">
                    <h5 class="text-lg font-semibold">List of Anime</h5>
                </div> --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full mx-auto divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody id="animeTableBody" class="bg-white divide-y divide-gray-200">
                            <!-- Table rows will be appended here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="updateAnimeModal" tabindex="-1" aria-labelledby="updateAnimeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateAnimeModalLabel">Update Anime Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select id="categoryOptions" class="form-select mb-3 w-full sm:w-3/4 md:w-1/2 lg:w-1/3">
                        <!-- Options go here -->
                    </select>
                </div>
                <div class="modal-footer">
                    <button id="closeCategoryModal" type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="updateCategory()" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="removeAnimeModal" tabindex="-1" aria-labelledby="removeAnimeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeAnimeModal">Remove Anime from this category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this anime from the category?</p>
                </div>
                <div class="modal-footer">
                    <button id="closeCategoryModal" type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">No</button>
                    <button type="button" onclick="deleteAnime()" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateCategoryModal">Remove Anime from this category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this anime from the category?</p>
                </div>
                <div class="modal-footer">
                    <button id="closeCategoryModal" type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">No</button>
                    <button type="button" onclick="deleteAnime()" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var categoryId = "{{ $category->id }}";
        let malId = '';
        let animeId = '';
        var id = user_data.id;
        animeList();
        categories();

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
                                <td class="d-flex align-items-center justify-content-start gap-2">
                                    <button class="btn btn-link text-primary" onclick="updateAnime(${anime.mal_id})">
                                        Update
                                    </button>
                                    <button class="btn btn-link text-danger" onclick="removeAnime(${anime.anime_table_id})">
                                        Remove
                                    </button>
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
            // Set mal_id in a hidden field or data attribute in the modal if needed
            malId = mal_id;
            // Open the modal
            $('#updateAnimeModal').modal('show');
        }


        function removeAnime(animeTableId) {
            // Set mal_id in a hidden field or data attribute in the modal if needed
            animeId = animeTableId;
            console.log(animeId);
            // Open the modal
            $('#removeAnimeModal').modal('show');
        }

        function categories() {
            let csrf = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: "GET",
                url: "{{ route('category.list') }}",
                data: {
                    user_id: id
                },
                headers: {
                    "X-CSRF-TOKEN": csrf
                },
                dataType: "json",
                success: function(response) {
                    // console.log("Success:", response);
                    $("#categoryOptions").empty();
                    response.data.forEach(category => {
                        $("#categoryOptions").append(
                            `<option value="${category.id}">${category.name}</option>`
                        );
                    });
                },
                error: function(response) {
                    console.log("Error:", response);
                }
            });
        }

        function updateCategory() {
            let category_id = $("#categoryOptions").val();
            let csrf = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: "POST",
                url: "{{ route('anime.update') }}",
                headers: {
                    "X-CSRF-TOKEN": csrf
                },
                data: {
                    category_id: category_id,
                    anime_id: malId
                },
                dataType: "json",
                success: function(response) {
                    console.log("Success:", response);
                    if (response.status == 200) {
                        Swal.fire({
                            title: "Success",
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                    animeList();
                    $('#closeCategoryModal').trigger('click');
                },
                error: function(response) {
                    console.log("Error:", response);
                    $(".errors").hide();
                    $(".errors").each(function(index, element) {
                        Object.entries(response.responseJSON.errors).forEach(error_element => {
                            if (error_element[0] == $(element).data('field')) {
                                $(element).text(error_element[1]);
                                $(element).show();
                            }
                        });
                    });
                }
            });
        }

        function deleteAnime() {
            let csrf = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: "DELETE",
                url: "{{ route('anime.delete') }}",
                headers: {
                    "X-CSRF-TOKEN": csrf
                },
                data: {
                    anime_id: animeId
                },
                dataType: "json",
                success: function(response) {
                    console.log("Success:", response);
                    if (response.status === 200) {
                        Swal.fire({
                            title: "Success",
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                    animeList(); // Refresh the list
                    // $('#closeCategoryModal').trigger('click');
                    $('#removeAnimeModal').modal('hide');
                },
                error: function(response) {
                    console.log("Error:", response);
                    Swal.fire({
                        title: "Error",
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        }
    </script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
@endsection
