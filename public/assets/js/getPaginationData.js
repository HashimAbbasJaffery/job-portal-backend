
const paginationTemplate = (link, name, active) => {
    return `<li class="page-item"><a class="page-link ${
        !link ? "disabled-link" : ""
    } ${
        active ? "active-page" : ""
    }" data-href="${link}" onclick="getPaginationData('${link}')">${name}</a></li>`;
};
const userTableRow = (
    name,
    email,
    badge_color,
    role,
    tasks_assigned,
    salary,
    id
) => {
    return `
    <tr>
    <th scope="row">${name}</th>
    <td>${email ? email : "Profile Not completed yet!"}</td>
    <td><span class="badge badge-pill badge-primary" style="background-color:${badge_color};">${role}</span></td>
    <td>${tasks_assigned} Tasks</td>
    <td>${salary}</td>
    <td>
    <a href="/user/${id}/update"
    class="btn btn-outline-primary text-primary update_button">Update</a>

    <button type="button" onclick="deleteRecord(${id})" class="btn btn-outline-danger">Delete</button>
      
      <a href="/task/${id}/create" class="btn btn-outline-warning">Assign Task</a>
    </td>
  </tr>
    `;
};
const getPaginationData = (link) => {
    axios
        .get(link)
        .then((res) => {
            const table = document.querySelector(".user_table");
            const data = res.data.data;

            let rowMarkup = "";
            data.forEach((datum) => {
                rowMarkup += userTableRow(
                    datum.name,
                    datum.email,
                    datum.profile.role.badge_color,
                    datum.profile.role.name,
                    datum.profile.tasks_assigned,
                    datum.profile.salary,
                    datum.id
                );
            });

            table.innerHTML = rowMarkup;

            // Re-rendering the pages links

            axios
                .get(link)
                .then((res) => {
                    const pagination = document.querySelector(".pagination");
                    const response = res.data;
                    const links = response.links;
                    console.log(links);
                    let linkMarkup = "";
                    links.forEach((link) => {
                        linkMarkup += paginationTemplate(
                            link.url,
                            link.label,
                            link.active
                        );
                    });
                    pagination.innerHTML = linkMarkup;
                })
                .catch((err) => {
                    console.log(err);
                });
        })
        .catch((err) => {
            console.log(err);
        });
};
