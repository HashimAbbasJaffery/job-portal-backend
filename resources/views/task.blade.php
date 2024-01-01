@php 
    use Carbon\Carbon;
@endphp 
<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    @endpush
    <div id="mainbod">
        <div id="user-table" class="users" style="color: white;">
            <h1>Task Details</h1>
            <div class="task-details">
                <div class="detail">
                    <h3 style="font-size: 20px;">Task Title</h3>
                    <p style="font-style: italic; color: white">{{ $task->name }}</p>
                </div>
                <div class="details">
                    <h3 style="font-size: 20px;">Task Description</h3>
                    <pre style="font-style: italic; color: white;">{{ $task->description }}</pre>
                </div>
                
                <div class="details" style="margin-bottom: 10px;">
                    <h3 style="font-size: 20px;">Expected Submission format</h3>
                    @php
                        $supported_extensions = json_decode($task->files->supported_extensions);
                    @endphp 
                    <div class="extensions" style="display: flex; flex-wrap: wrap; width: 50%;">
                        @foreach($supported_extensions as $extension)
                            <div class="badge badge-pill badge-primary" style="margin: 5px;">{{ $extension }}</div>
                        @endforeach
                    </div>
                </div>
                {{-- <a href="/task/{{ $task->id }}" class="btn btn-outline-danger delete_button"
                                    >Details</a> --}}
                
                @php
                                    
                    $targetDate = Carbon::parse($task->deadline);
                    $today = Carbon::now();
                    
                    $daysRemaining = $today->diffInDays($targetDate);
                    $isPastDate = $today->gt($targetDate);

                @endphp
                <div class="details">
                    <h3 style="font-size: 20px;">Deadline</h3>
                    <div class="extensions" style="display: flex; flex-wrap: wrap; width: 50%; color: white;">
                     @if($daysRemaining === 0) 
                        <p>{{ $targetDate->isToday() ? "Today" : "Tomorrow" }}</p>
                    @else 
                        <p>{{ $daysRemaining }} day(s) {{ $isPastDate ? " Ago" : "" }}</p>
                    @endif
                    </div>
                </div>
                
                <div class="details" style="margin-bottom: 10px;">
                    <a href="/chats?assigner={{ $task->assigner_id }}" class="btn btn-outline-primary"
                                    >Message <span style="font-weight: bold; text-transform: capitalize;">{{ $task->assigned_by->name }}</span></a>
                    <label for="upload_file">
                        <p style="margin-bottom: 0pc;" class="btn btn-outline-success upload_file_button {{ $task->status === "pending approval" ? 'disabled submitted' : ""}}"
                        >Submit</p>
                        <input type="file" id="upload_file" style="display: none" {{ $task->status === "pending approval" ? 'disabled' : ""}}>
                    </label>
                </div>
                <p class="text text-danger file-mismatch"></p>
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
        const searchForm = document.getElementById("upload_file");
        searchForm.addEventListener("change", function(e) {
            e.preventDefault();
            const upload_file = document.getElementById("upload_file");
            let settings = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            axios.post("/task/{{ $task->id }}/submit", {
                upload_file: upload_file.files[0],
                file_id: '{{ $task->files->id }}'
            }, settings)
                .then(res => {
                    console.log(res);
                    const fileMismatch = document.querySelector(".file-mismatch");
                    fileMismatch.textContent = "";
                    if(!res.data.status) {
                        const fileMismatch = document.querySelector(".file-mismatch");
                        fileMismatch.textContent = res.data.errors;
                    } 
                    if(res.data === 1) {


                        const flashMessage = document.querySelector(".flash-message");
                            flashMessage.textContent =
                                "Task submitted successfully!";
                            flashMessage.classList.remove("none");
                            flashMessage.classList.add("animate__backInRight");
                            flashMessage.classList.remove("animate__backOutRight");
                            setTimeout(() => {
                                flashMessage.classList.remove("animate__backInRight");
                                flashMessage.classList.add("animate__backOutRight")
                            }, 4000)

                                
                            const upload_file_button = document.querySelector(".upload_file_button");
                            const upload_field = document.getElementById("upload_file");

                            upload_file_button.classList.add("disabled");
                            upload_field.setAttribute("disabled", "");
                    }
                })
                .catch(err => {
                    console.log(err)
                })
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
