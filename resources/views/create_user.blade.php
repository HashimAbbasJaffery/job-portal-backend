<x-app-layout>
    @push("styles")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    @endpush
    <div id="mainbod">
        <div id="user-table" class="users">
            <h1>Create User</h1>
            <form id="createUser" class="createUser">
                <div class="create-user" style="margin-top: 20px;">
                    <label for="select_role" style="width: 100%;">
                        <p>Select Role</p>
                        <select id="select_role" class="form-control create-user-field">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label for="name" class="create-user-field">
                        <p>Name</p>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" aria-describedby="emailHelp">
                        </div>
                    </label>
                    <label for="last_name" class="create-user-field">
                        <p>last name</p>
                        <div class="form-group">
                            <input type="text" class="form-control" id="last_name" aria-describedby="emailHelp">
                        </div>
                    </label>
                    <label for="salary" class="create-user-field">
                        <p>Salary</p>
                        <div class="form-group">
                            <input type="number" class="form-control" id="salary" aria-describedby="emailHelp">
                        </div>
                    </label>

                    <button type="submit" class="btn btn-dark mb-2">Create User</button>
                    <button type="submit" class="btn btn-primary mb-2">Cancel</button>
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
            const getElementValue = id => {
                const element = document.getElementById(id);
                return element.value;
            }
            const form = document.getElementById("createUser");
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                const role = getElementValue("select_role");
                const name = getElementValue("name");
                const last_name = getElementValue("last_name");
                const salary = getElementValue("salary");

                axios.post("/users/create", {
                    role,
                    name,
                    last_name,
                    salary
                })
                .then(res => {
                    console.log(res);
                })
                .catch(err => {
                    console.log(err);
                })

            })

        </script>
    @endpush
</x-app-layout>