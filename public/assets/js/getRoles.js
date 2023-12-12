import boilerPlate from "./paginationBoilerplate.js";
import debounce from "./debounce.js";

const roleTableRow = role => {
    return (
        `
        <tr>
            <th scope="row">${role.name}</th>
            <td><i class="fa-solid ${ role.can_create_user ? 'fa-check' : 'fa-xmark' }" style="color: ${ role.can_create_user ? '#42df6d' : 'red' };"></i></td>
            <td><i class="fa-solid ${ role.can_edit_user ? 'fa-check' : 'fa-xmark' }" style="color: ${ role.can_edit_user ? '#42df6d' : 'red' };"></i></td>
            <td><i class="fa-solid ${ role.can_assign_tasks ? 'fa-check' : 'fa-xmark' }" style="color: ${ role.can_assign_tasks ? '#42df6d' : 'red' };"></i></td>
            <td><i class="fa-solid ${ role.can_notify_user ? 'fa-check' : 'fa-xmark' }" style="color: ${ role.can_notify_user ? '#42df6d' : 'red' };"></i></td>
            <td>
                <a href="/role/${role.id}/update"
                    class="btn btn-outline-primary text-primary update_button">Update</a>
                <button type="button" onclick="deleteRecord('${role.id}')" class="btn btn-outline-danger delete_button"
                    data-id="${role.id}">Delete</button>
            </td>
        `
    )
}


const search = document.getElementById("search");
const getPaginationLinks = debounce(() => {
    const uri = `/api/roles/get?keyword=${search.value}`;
    boilerPlate(`/api/roles/get?keyword=${search.value}`);

    // rendering the data which satisfies by the keyword

    axios
    .get(uri)
    .then((res) => {
        const table = document.querySelector(".user_table");
        const data = res.data.data;
        console.log(data);
        
        let rowMarkup = "";
        data.forEach((datum) => {
            rowMarkup += roleTableRow(datum);
        });

        table.innerHTML = rowMarkup;
    })

}, 250)
search.addEventListener("keyup", getPaginationLinks)

boilerPlate("/api/roles/get");
export default boilerPlate;