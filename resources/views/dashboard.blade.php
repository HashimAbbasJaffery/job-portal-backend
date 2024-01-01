@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    @endpush
    <div id="mainbod" style="background:none ">
    {{-- <img style=" margin:auto;" src="/assets/img.png" height="500px"> --}}
    {{-- <h1 align="center">Logged In</h1>     --}}
    <div class="stats">
        <div clas="total-users stats-card" style="width: 33.33%; justify-content: space-between;">
            <div class="card" style="border-radius: 15px;padding: 10px;color: #111433; text-align: center;margin-top: 40px;width: 90%;background:linear-gradient(90deg , #4aff7b , #2dd85b) !important;">
                <h2 style="font-size: 25px;">
                    Users <i style="color: #111433; font-size: 20px;" class="fa-solid fa-user"></i>
                </h2>
                <p style="margin: 0px;">{{ number_format($users) }} User{{ $users === 1 ? "" : "s"}}</p>
            </div>
        </div>
        <div clas="total-tasks stats-card" style="width: 33.33%;">
            <div class="card" style="border-radius: 15px;padding: 10px;color: #111433; text-align: center;margin-top: 40px;width: 90%;background:linear-gradient(90deg , #4aff7b , #2dd85b) !important;">
                <h2 style="font-size: 25px;">
                    Assigned Tasks <i style="color: #111433; font-size: 20px;" class="fa-solid fa-hourglass-start"></i>
                </h2>
                <p style="margin: 0px;">{{ number_format($tasks) }} Task{{ $tasks === 1 ? "" : "s" }}</p>
            </div>
        </div>
        <div clas="total-completed-task stats-card" style="width: 33.33%;">
            <div class="card" style="border-radius: 15px;padding: 10px;color: #111433; text-align: center;margin-top: 40px;width: 90%;background:linear-gradient(90deg , #4aff7b , #2dd85b) !important;">
                <h2 style="font-size: 25px;">
                    Completed Tasks 
                    <i style="color: #111433; font-size: 20px;" class="fa-solid fa-check"></i>
                </h2>
                <p style="margin: 0px;">{{ number_format($completedTasks) }} Completed Task{{ $completedTasks === 1 ? "" : "s" }}</p>
            </div>
        </div>

    </div>
    <h1 style="margin-top: 50px;">Recent tasks</h1>
            
                @if(count($tasksColletion) > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Expected file format</th>
                            <th scope="col">Assigned By</th>
                            <th scope="col">Due in</th>
                        </tr>
                    </thead>
                    <tbody class="user_table">
                        @foreach ($tasksColletion as $task)
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else 
                    <div class="alert alert-success">
                        No Recent Tasks were found!
                    </div>
                @endif
        
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
