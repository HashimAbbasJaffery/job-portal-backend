import paginationTemplate from "./paginationTemplate.js";
import debounce from "./debounce.js";
import boilerPlate from "./paginationBoilerplate.js";



const userTableRow = (
    id,
    name,
    email,
    badge_color,
    role,
    tasks_assigned,
    salary
) => {
    return `
    <tr>
    <th scope="row">${name}</th>
    <td>${email ? email : "Profile Not completed yet!"}</td>
    <td><span class="badge badge-pill badge-primary" style="background-color:${badge_color};">${role}</span></td>
    <td>${tasks_assigned} Tasks</td>
    <td>${salary}</td>
    <td>
      <button type="button" class="btn btn-outline-primary">Update</button>
      <button type="button" class="btn btn-outline-danger">Delete</button>
      <a href="/task/${id}/create" class="btn btn-outline-warning">Assign Task</a>
    </td>
  </tr>
    `;
};

const search = document.getElementById("search");
const getPaginationLinks = debounce(() => {
    const uri = `/api/users/get?keyword=${search.value}`;
    boilerPlate(`/api/users/get?keyword=${search.value}`);

    // rendering the data which satisfies by the keyword

    axios
    .get(uri)
    .then((res) => {
        const table = document.querySelector(".user_table");
        const data = res.data.data;
        console.log(data);

        let rowMarkup = "";
        data.forEach((datum) => {
            rowMarkup += userTableRow(
                datum.id,
                datum.name,
                datum.email,
                datum.profile.role.badge_color,
                datum.profile.role.name,
                datum.profile.tasks_assigned,
                datum.profile.salary
            );
        });

        table.innerHTML = rowMarkup;
    })

}, 250)
search.addEventListener("keyup", getPaginationLinks)
boilerPlate("/api/users/get");
export default boilerPlate;