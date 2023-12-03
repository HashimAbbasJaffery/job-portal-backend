<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    @endpush
    <div id="mainbod">
        <div id="user-table" class="users">
            <h1>Users List</h1>
            <div class="users-list">
                <div class="users-list-header">
                    <div class="search search-user">
                        <form id="search-users">
                            <input type="text" id="search" placeholder="Search Users..." />
                        </form>
                    </div>
                    <button type="submit" class="btn btn-dark create_user">Create User</button>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Task Assigned</th>
                            <th scope="col">Salary</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="user_table">
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user->name }}</th>
                                <td>{{ $user->email ? $user->email : 'Profile Not completed yet!' }}</td>
                                <td><span class="badge badge-pill badge-primary"
                                        style="background-color: {{ $user->profile->role->badge_color }};">{{ $user->profile->role->name }}</span>
                                </td>
                                <td>{{ $user->profile->tasks_assigned }} Tasks</td>
                                <td>{{ $user->profile->salary }}</td>
                                <td>
                                    <a href="/user/{{ $user->id }}/update"
                                        class="btn btn-outline-primary text-primary update_button">Update</a>
                                    <button type="button" class="btn btn-outline-danger delete_button"
                                        data-id="{{ $user->id }}">Delete</button>
                                    <button type="button" class="btn btn-outline-warning">Notify</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="/assets/js/getPaginationData.js"></script>
    <script src="/assets/js/getUsers.js" type="module"></script>
    <script>
        const create_user = document.querySelector(".create_user");
        create_user.addEventListener("click", function() {
            window.location.href = "/users/create";
        })
    </script>
    <script>
        const searchForm = document.getElementById("search-users");
        searchForm.addEventListener("submit", function(e) {
            e.preventDefault();
            alert("Submitted");
        })
    </script>
    <script>
        const buttons = document.querySelectorAll(".delete_button");
        const deleteRecord = id => {
            Swal.fire({
                title: "Do you really want to delete the user?",
                showDenyButton: true,
                confirmButtonText: "Delete",
                denyButtonText: `Cancel`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    
                    axios.delete(`/user/${id}/delete`)
                        .then(res => {
                            if (res.data) {
                                window.location.href = "/users";
                            }
                        })
                        .catch(err => {
                            console.log(err)
                        })

                } else if (result.isDenied) {

                }
            });
        }
        buttons.forEach(button => {
            button.addEventListener("click", function() {
              deleteRecord(button.dataset.id)
            })
        })
    </script>
</x-app-layout>
