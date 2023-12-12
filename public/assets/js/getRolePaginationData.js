const paginationTemplate = (link, name, active) => {
    return `<li class="page-item"><a class="page-link ${
        !link ? "disabled-link" : ""
    } ${
        active ? "active-page" : ""
    }" data-href="${link}" onclick="getPaginationData('${link}')">${name}</a></li>`;
};


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
const getPaginationData = (link) => {
    axios
        .get(link)
        .then((res) => {
            const table = document.querySelector(".user_table");
            const data = res.data.data;

            let rowMarkup = "";
            data.forEach((datum) => {
                rowMarkup += roleTableRow(datum);
            });

            table.innerHTML = rowMarkup;

            // Re-rendering the pages links

            axios
                .get(link)
                .then((res) => {
                    const pagination = document.querySelector(".pagination");
                    const response = res.data;
                    const links = response.links;
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
