<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    @endpush
    <div id="mainbod">
        <div id="user-table" class="users">
            <h1>Roles List</h1>
            <div class="users-list">
                <div class="users-list-header">
                    <div class="search search-user">
                        <form id="search-users">
                            <input type="text" id="search" placeholder="Search Users..." />
                        </form>
                    </div>
                    <button type="submit" class="btn btn-dark create_user">Create Role</button>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Create User</th>
                            <th scope="col">Edit User</th>
                            <th scope="col">View Users</th>
                            <th scope="col">Delete User</th>
                            
                            <th scope="col">Create Role</th>
                            <th scope="col">Edit Role</th>
                            <th scope="col">View Roles</th>
                            <th scope="col">Delete Role</th>
                    
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="user_table">
                        @foreach ($roles as $role)
                            <tr>
                                <th scope="row">{{ $role->name }}</th>
                                @if($role->can_create_user)
                                    <td><i class="fa-solid fa-check" style="color: #42df6d;"></i></td>
                                @else 
                                    <td><i class="fa-solid fa-xmark" style="color: red;"></i></td>
                                @endif
                                @if($role->can_edit_user)
                                    <td><i class="fa-solid fa-check" style="color: #42df6d;"></i></td>
                                @else 
                                    <td><i class="fa-solid fa-xmark" style="color: red;"></i></td>
                                @endif
                                @if($role->can_assign_tasks)
                                    <td><i class="fa-solid fa-check" style="color: #42df6d;"></i></td>
                                @else 
                                    <td><i class="fa-solid fa-xmark" style="color: red;"></i></td>
                                @endif
                                @if($role->can_notify_user)
                                    <td><i class="fa-solid fa-check" style="color: #42df6d;"></i></td>
                                @else 
                                    <td><i class="fa-solid fa-xmark" style="color: red;"></i></td>
                                @endif
                                
                                @if($role->can_create_role)
                                    <td><i class="fa-solid fa-check" style="color: #42df6d;"></i></td>
                                @else 
                                    <td><i class="fa-solid fa-xmark" style="color: red;"></i></td>
                                @endif
                                
                                @if($role->can_edit_role)
                                    <td><i class="fa-solid fa-check" style="color: #42df6d;"></i></td>
                                @else 
                                    <td><i class="fa-solid fa-xmark" style="color: red;"></i></td>
                                @endif

                                
                                @if($role->can_view_role)
                                    <td><i class="fa-solid fa-check" style="color: #42df6d;"></i></td>
                                @else 
                                    <td><i class="fa-solid fa-xmark" style="color: red;"></i></td>
                                @endif
                                
                                @if($role->delete_role)
                                    <td><i class="fa-solid fa-check" style="color: #42df6d;"></i></td>
                                @else 
                                    <td><i class="fa-solid fa-xmark" style="color: red;"></i></td>
                                @endif
                                <td>
                                    @can("allowed-role-update", auth()->user())
                                        <a href="/role/{{ $role->id }}/update"
                                            class="btn btn-outline-primary text-primary update_button">Update</a>
                                    @endcan
                                    @can("allowed-role-delete", auth()->user())
                                        <button type="button" class="btn btn-outline-danger delete_button"
                                            data-id="{{ $role->id }}">Delete</button>
                                    @endcan
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
    <script src="/assets/js/getRolePaginationData.js"></script>
    <script src="/assets/js/getRoles.js" type="module"></script>
    <script>
        const create_user = document.querySelector(".create_user");
        create_user.addEventListener("click", function() {
            window.location.href = "/role/create";
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
                    
                    axios.delete(`/role/${id}/delete`)
                        .then(res => {
                            if (res.data) {
                                window.location.href = "/roles";
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
