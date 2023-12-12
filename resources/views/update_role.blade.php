<x-app-layout>
    @push("styles")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    @endpush
    <div id="mainbod">
        <div id="user-table" class="users">
            <h1>Update Role</h1>
            <form id="createUser" class="createUser">
                <div class="create-user" style="margin-top: 20px;">
                    <label for="name" class="create-user-field">
                        <p>Name</p>
                        <div class="form-group" style="position: relative;">
                            <input type="text" value="{{ $role->name }}" class="form-control name"  placeholder="Enter name" aria-describedby="emailHelp">
                        </div>
                    </label>
                    <div class="switches" style="display: flex; justify-content: space-around;">
                        
                        <div class="custom-control custom-switch">
                            <p>Create User</p>
                            <input type="checkbox" @checked($role->can_create_user) value="{{ $role->can_create_user ? 'on' : 'off' }}" id="switch" class="create_user switch"/><label onclick="toggleSwitch('create_user')" for="switch" class="switchDesc" id="switchLabel">Toggle</label>
                        </div>
                        <div class="custom-control custom-switch">
                            <p>Edit User<p>
                            <input type="checkbox" id="switch1" @checked($role->can_edit_user)  value="{{ $role->can_edit_user ? 'on' : 'off' }}" class="edit_user switch"/><label onclick="toggleSwitch('edit_user')" for="switch1" class="switchDesc" id="switchLabel">Toggle</label>
                        </div>
                         <div class="custom-control custom-switch">
                         <p>Assign Tasks<p>
                            <input type="checkbox" id="switch2" @checked($role->can_assign_tasks)  value="{{ $role->can_assign_tasks ? 'on' : 'off' }}" class="assign_task switch"/><label onclick="toggleSwitch('assign_task')" for="switch2" class="switchDesc" id="switchLabel">Toggle</label>
                        </div>
                         <div class="custom-control custom-switch">
                         <p>Notify User<p>
                            <input type="checkbox" id="switch3" @checked($role->can_notify_user) value="{{ $role->can_notify_user ? 'on' : 'off' }}"  class="notify_user switch"/><label onclick="toggleSwitch('notify_user')" for="switch3" class="switchDesc" id="switchLabel">Toggle</label>
                        </div>
                        
                    </div>

                    <button type="submit" class="btn btn-dark mb-2">Update Role</button>
                    <button type="submit" class="btn btn-primary mb-2 cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    @push("scripts")
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
        
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            const toggleSwitch = className => {
                const element = document.querySelector(`.${className}`);
                if(element.value === "on") {
                    element.value = "off";
                } else {
                    element.value = "on";
                }
            }
        </script>
        <script>
            const getElementValue = className => {
                const element = document.querySelector(className);
                return element.value;
            }
            const form = document.getElementById("createUser");
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                const name = getElementValue(".name");
                const create_user = getElementValue(".create_user")
                const edit_user = getElementValue(".edit_user")
                const assign_task = getElementValue(".assign_task")
                const notify_user = getElementValue(".notify_user")

                axios.post("/role/{{ $role->id }}/update", {
                    name,
                    create_user,
                    edit_user,
                    assign_task,
                    notify_user
                })
                .then(res => {
                    const errors = res.data.errors;
                    if(errors) {
                        const fields = [ "name" ];
                        fields.forEach(field => {
                            const element = document.getElementById(field);
                            element.classList.remove("empty-field");
                            element.classList.remove("err");
                            element.setAttribute("placeholder", "Enter " + field.replace(/[-!@#$%^&*())_-]/g, " "));
                        });
                        for(let error in errors) {
                            const field = error;
                            const element = document.getElementById(field);
                            element.classList.add("empty-field");
                            element.classList.add("err");
                            element.setAttribute("placeholder", errors[error]);
                        }
                    } else {
                        window.location.href = "/roles"
                    }
                })
                .catch(err => {
                    console.log(err);
                })

            })

        </script>
        <script>
            const cancelButton = document.querySelector(".cancel");
            cancelButton.addEventListener("click", function() {
                window.location.href = "/users";
            })
        </script>
    @endpush
</x-app-layout>