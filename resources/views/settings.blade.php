<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    @endpush
    <div id="mainbod">
        <div id="user-table" class="users">
            <div class="cover">
                <label for="upload-pic">
                    <div class="profile" style="cursor: pointer;">
                        @if (!auth()->user()->profile->profile_picture)
                            <img style="border-radius: 50%;" class="profile-image" src="https://placehold.co/110x110">
                        @else
                            <img style="border-radius: 50%; width: 110px; height: 110px;" class="profile-image"
                                src="{{ '/uploads/' . auth()->user()->profile->profile_picture }}">
                        @endif
                        <div class="edit-photo">
                            <i class="fa-solid fa-camera"
                                style="font-size: 17px;background: white; padding: 5px; border-radius: 50%;position: absolute; bottom: 5px; right: 10px;"></i>
                        </div>
                    </div>
                    <input type="file" id="upload-pic" style="display: none;" />
                    <label>
            </div>
            <div style="display: flex;">
                <div style="width:50%; margin-right: 15px; margin-top: 10px;">
                    <h1>Personal Information</h1>
                    <form id="updateProfile" class="updateProfile">
                        <div class="create-user" style="margin-top: 20px;">
                            <label for="name" class="create-user-field">
                                <p>Name</p>
                                <div class="form-group" style="position: relative;">
                                    <input type="text" value="{{ auth()->user()->name }}" id="name"
                                        class="form-control name" placeholder="Enter name" aria-describedby="emailHelp">
                                    <p class="text text-danger input-field-error" style="margin-top: 10px;"
                                        id="name_error">
                                    </p>

                                </div>
                            </label>
                            <label for="name" class="create-user-field">
                                <p>Last Name</p>
                                <div class="form-group" style="position: relative;">
                                    <input type="text" value="{{ auth()->user()->last_name }}" id="last_name"
                                        class="form-control name" placeholder="Enter Last name"
                                        aria-describedby="emailHelp">
                                    <p class="text text-danger input-field-error" style="margin-top: 10px;"
                                        id="last_name_error"></p>

                                </div>
                            </label>
                            <label for="email" class="create-user-field">
                                <p>Email</p>
                                <div class="form-group" style="position: relative;">
                                    <input type="email" value="{{ auth()->user()->email }}" id="email"
                                        class="form-control email" placeholder="Enter Email"
                                        aria-describedby="emailHelp">
                                    <p class="text text-danger input-field-error" style="margin-top: 10px;"
                                        id="email_error"></p>
                                </div>
                            </label>
                            <label for="address" class="create-user-field">
                                <p>Address</p>
                                <div class="form-group" style="position: relative;">
                                    <textarea type="text" class="form-control address" id="address" placeholder="Enter Address"
                                        aria-describedby="emailHelp">{{ auth()->user()->address }}</textarea>
                                    <p class="text text-danger input-field-error" style="margin-top: 10px;"
                                        id="address_error"></p>
                                </div>
                            </label>

                            <button type="submit" class="btn btn-dark mb-2">Update Information</button>
                        </div>
                    </form>
                </div>
                <div>
                    <h1 style="margin-top: 10px;">Security Information</h1>
                    <form id="updatePassword" class="updatePassword">
                        <div class="create-user" style="margin-top: 20px;">
                            <label for="password" class="create-user-field">
                                <p>Password</p>
                                <div class="form-group" style="position: relative;">
                                    <input type="password" class="form-control name" id="old_password"
                                        placeholder="Enter New password" aria-describedby="emailHelp">
                                    <p class="text text-danger input-field-error" style="margin-top: 10px;"
                                        id="old_password_error"></p>
                                </div>
                            </label>
                            <label for="confirmation_password" class="create-user-field">
                                <p>Confirm Password</p>
                                <div class="form-group" style="position: relative;">
                                    <input type="password" class="form-control confirmation_password"
                                        id="new_password" placeholder="Confirm Password"
                                        aria-describedby="emailHelp">
                                    <p class="text text-danger input-field-error" style="margin-top: 10px;"
                                        id="new_password_error"></p>
                                </div>
                            </label>
                            <button type="submit" class="btn btn-dark mb-2">Update Security Details</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
        </script>

        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            const uploadPic = document.getElementById("upload-pic");
            uploadPic.addEventListener("change", function() {
                let settings = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                axios.post("/setting/upload_profile_pic", {
                        picture: uploadPic.files[0]
                    }, settings)
                    .then(res => {
                        if (res.data.status === 0) {

                            console.log(res);
                            const flashMessage = document.querySelector(".flash-message");
                            flashMessage.textContent =
                                "File size must be less than 1MB, and file extensions must be jpg, png or jpeg";
                            flashMessage.classList.remove("none");
                            flashMessage.classList.add("animate__backInRight");
                            flashMessage.classList.remove("animate__backOutRight");
                            setTimeout(() => {
                                flashMessage.classList.remove("animate__backInRight");
                                flashMessage.classList.add("animate__backOutRight")
                            }, 4000)

                        } else {
                            const filename = res.data;
                            const profileImage = document.querySelector(".profile-image");
                            profileImage.setAttribute("src", `/uploads/${filename}`);
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            })
        </script>
        <script>
            const toggleSwitch = className => {
                const element = document.querySelector(`.${className}`);
                if (element.value === "on") {
                    element.value = "off";
                } else {
                    element.value = "on";
                }
            }
        </script>
        <script>
            const updatePasswordForm = document.getElementById("updatePassword");
            updatePasswordForm.addEventListener("submit", function(e) {
                e.preventDefault();
                const old_password = document.getElementById("old_password");
                const new_password = document.getElementById("new_password");
                axios.post("/setting/update_password", {
                        old_password: old_password.value,
                        new_password: new_password.value
                    })
                    .then(res => {
                        console.log(res.data);
                        const errors = document.querySelectorAll(".input-field-error");
                        errors.forEach(error => {
                            error.textContent = "";
                        })
                        if (!res.data.status) {
                            const errors = res.data.error;
                            for (let error in errors) {
                                const element = document.getElementById(`${error}_error`);
                                element.textContent = errors[error];
                            }
                        } else {
                            const flashMessage = document.querySelector(".flash-message");
                            flashMessage.textContent = "Password has been reset!";
                            flashMessage.classList.remove("none");
                            flashMessage.classList.add("animate__backInRight");
                            flashMessage.classList.remove("animate__backOutRight");
                            setTimeout(() => {
                                flashMessage.classList.remove("animate__backInRight");
                                flashMessage.classList.add("animate__backOutRight")
                            }, 4000)
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
                    .finally(() => {
                        old_password.value = "";
                        new_password.value = "";
                    })
            })
        </script>
        <script>
            const getElementValue = className => {
                const element = document.querySelector(className);
                return element.value;
            }
            const form = document.getElementById("updateProfile");
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                const name = getElementValue("#name")
                const last_name = getElementValue("#last_name")
                const email = getElementValue("#email")
                const address = getElementValue("#address")

                axios.post("/setting/update_profile", {
                        name,
                        last_name,
                        email,
                        address
                    })
                    .then(res => {
                        console.log(res);
                        const errors = res.data.errors;
                        const fields = ["name", "last_name", "email", "address"];
                        fields.forEach(field => {
                            const errors = document.querySelectorAll(".input-field-error");
                            errors.forEach(error => {
                                error.textContent = "";
                            })
                        });
                        if (errors) {
                            for (let error in errors) {
                                const element = document.getElementById(`${error}_error`);
                                element.textContent = errors[error];
                            }
                        } else {
                            if (res.data === 203) return;
                            const flashMessage = document.querySelector(".flash-message");
                            flashMessage.textContent = "Profile information updated!";
                            flashMessage.classList.remove("none");
                            flashMessage.classList.add("animate__backInRight");
                            flashMessage.classList.remove("animate__backOutRight");
                            setTimeout(() => {
                                flashMessage.classList.remove("animate__backInRight");
                                flashMessage.classList.add("animate__backOutRight")
                            }, 4000)
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
