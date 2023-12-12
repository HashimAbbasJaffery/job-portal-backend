<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    @endpush
    <div id="mainbod" style="background:none; display:inline-flex; justify-content:center; ">
    <img style=" margin:auto;" src="/assets/img.png" height="500px">
    <h1 align="center">Logged In</h1>    
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
