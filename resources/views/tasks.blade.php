@php
use Carbon\Carbon;
@endphp
<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    @endpush
    <div id="mainbod">
        <div id="user-table" class="users">
            <h1>Tasks List</h1>
            <div class="users-list">
                <div class="users-list-header">
                    <div class="search search-user">
                        <form id="search-users">
                            <input type="text" id="search" placeholder="Search Users..." />
                        </form>
                    </div>
                </div>
                @if(count($tasks) > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Expected file format</th>
                            <th scope="col">Assigned By</th>
                            <th scope="col">Due in</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="user_table">
                        @foreach ($tasks as $task)
                            <tr>
                                <th scope="row">{{ $task->name }}</th>
                                @php
                                    $supported_extensions = json_decode($task->files->supported_extensions);
                                    $supported_extensions = implode(", ", $supported_extensions);
                                @endphp 
                                @php
                                    
                                    $targetDate = Carbon::parse($task->deadline);
                                    $today = Carbon::now();
                                    
                                    $daysRemaining = $today->diffInDays($targetDate);
                                    $isPastDate = $today->gt($targetDate);

                                @endphp
                                <td>{{ $supported_extensions }}</td>
                                <td>{{ $task->assigned_by->name }}</td>
                                @if($daysRemaining === 0) 
                                    <td>{{ $targetDate->isToday() ? "Today" : "Tomorrow" }}</td>
                                @else 
                                    <td>{{ $daysRemaining }} day(s) {{ $isPastDate ? " Ago" : "" }}</td>
                                @endif
                                <td>
                                    <a href="/task/{{ $task->id }}" class="btn btn-outline-danger"
                                    >Details</a>
                                    
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
                @else 
                    <div class="alert alert-success" style="margin-top: 10px;">
                        No Task found... Hooray!!
                    </div>
                @endif
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
