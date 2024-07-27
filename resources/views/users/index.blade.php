@extends('layouts.app')

<link href="{{ asset('css/getbootstrap.css') }}" rel="stylesheet">
@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Profile</h1>
            <a class="badge bg-dark text-white ms-2" href="{{route('home')}}">
                Return to the Main page
            </a>
        </div>
        <div class="row">
            <div class="col-md-4 col-xl-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Details</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Christina Mason"
                            class="img-fluid rounded-circle mb-2" width="128" height="128" />
                        <h5 class="card-title mb-0">{{ $user->username }}</h5>
                        <div class="text-muted mb-2">{{ $user->email }}</div>

                        <div>
                            {{-- <a class="btn btn-primary btn-sm" href="#">Follow</a> --}}
                            {{-- <a class="btn btn-primary btn-sm" href="#"><span data-feather="message-square"></span>
                                Message</a> --}}
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="p-4">
                        <a href="#" class="text-blue-500 hover:underline block mb-3" data-toggle="modal"
                            data-target="#addCategoryModal">
                            Add Category
                        </a>
                        <hr class="my-2 border-gray-300">
                        <h5 class="text-lg font-semibold mt-3">My Categories</h5>
                        <ul id="categoryList" class="list-none mb-0 mt-2">
                            <!-- Category items go here -->
                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-md-8 col-xl-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Profile</h5>
                    </div>
                    <form>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input name="username" type="text" class="form-control" id="username" value="">
                                <i id="errors" class="errors text-danger font-weight-bold" data-field="username"
                                    style="display:none"></i>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" id="email" value="">
                                <i id="errors" class="errors text-danger font-weight-bold" data-field="email"
                                    style="display:none"></i>
                            </div>

                            <div class="mb-3">
                                <label for="old_password" class="form-label">Old Password</label>
                                <input id="old_password" type="password" class="form-control" name="old_password"
                                    autocomplete="current-password">
                                <i id="errors" class="errors text-danger font-weight-bold" data-field="old_password"
                                    style="display:none"></i>
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input id="new_password" type="password" class="form-control" name="new_password"
                                    autocomplete="new-password">
                                <i id="errors" class="errors text-danger font-weight-bold" data-field="new_password"
                                    style="display:none"></i>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input id="confirm_password" type="password" class="form-control" name="confirm_password"
                                    autocomplete="new-password">
                                <i id="errors" class="errors text-danger font-weight-bold" data-field="confirm_password"
                                    style="display:none"></i>
                            </div>

                            <div class="mb-3">
                                <label for="profile_pic" class="form-label">Profile Picture</label>
                                <input id="profile_pic" type="file" class="form-control" name="profile_pic">
                            </div>

                            <button type="button" onclick="updateUser()" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add a Category</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input name="name" type="text" class="form-control" id="name" value="">
                        <i id="errors" class="errors text-danger font-weight-bold" data-field="name"
                            style="display:none"></i>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input name="description" type="text" class="form-control" id="description" value="">
                        <i id="errors" class="errors text-danger font-weight-bold" data-field="description"
                            style="display:none"></i>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closeCategoryModal" type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                    <button type="button" onclick="createCategory()" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var id = user_data.id;
        editUser();
        categories();

        function updateUser() {
            let username = $("#username").val();
            let email = $("#email").val();
            let oldPassword = $("#old_password").val(); // Add old_password field
            let newPassword = $("#new_password").val(); // Add new_password field
            let confirmPassword = $("#confirm_password").val(); // Add confirm_password field
            let attachment = $('#profile_pic')[0].files[0];
            let csrf = $('meta[name="csrf-token"]').attr('content');

            // Ensure attachment exists before appending to formData
            let formData = new FormData();
            formData.append('email', email);
            formData.append('username', username);

            if (oldPassword) {
                formData.append('old_password', oldPassword); // Add old_password to formData
                formData.append('new_password', newPassword); // Add new_password to formData
                formData.append('confirm_password', confirmPassword); // Add confirm_password to formData
            }

            if (attachment) {
                formData.append('profile_picture', attachment);
            }

            $.ajax({
                type: "POST",
                url: "{{ route('user.update', ['id' => 'id']) }}".replace('id', id),
                headers: {
                    "X-CSRF-TOKEN": csrf
                },
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    console.log("Success:", response);
                    if (response.status == 200) {
                        Swal.fire({
                            title: "Success",
                            text: response.text,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then(() => {
                            editUser(id);
                        });
                    } else {
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
                    $("#old_password").val('');
                    $("#new_password").val('');
                    $("#confirm_password").val('');
                    $(".errors").hide();
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

        function editUser() {
            var csrf = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('user.edit', ['id' => 'id']) }}".replace('id', id),
                method: "GET",
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    // console.log(csrf);
                    $("#username").val(response.data.username);
                    $("#email").val(response.data.email);
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
                    console.log("Success:", response);
                    $("#categoryList").empty();
                    response.data.forEach(category => {
                        let categoryRoute =
                            "{{ route('anime.by-category', ['category_id' => 'category_id']) }}"
                            .replace('category_id', category.id);
                        $("#categoryList").append(
                            `<li class="mb-1"><a href="${categoryRoute}">${category.name}</a></li>`
                        );
                    });
                },
                error: function(response) {
                    console.log("Error:", response);
                }
            });
        }

        function createCategory() {
            let name = $("#name").val();
            let description = $("#description").val();
            let csrf = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: "POST",
                url: "{{ route('category.store') }}",
                headers: {
                    "X-CSRF-TOKEN": csrf
                },
                data: {
                    user_id: id,
                    name: name,
                    description: description
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
                        }).then(() => {
                            categories();
                            $('#closeCategoryModal').trigger('click');
                        });
                    } else {
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
                    $("#old_password").val('');
                    $("#new_password").val('');
                    $("#confirm_password").val('');
                    $(".errors").hide();
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
    </script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
@endsection
