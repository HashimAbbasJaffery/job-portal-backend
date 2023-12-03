const userTableRow = (name, email, badge_color, role, tasks_assigned, salary) => {
    return `
    <tr>
    <th scope="row">${name}</th>
    <td>{{ ${email} ? ${email} : "Profile Not completed yet!"}}</td>
    <td><span class="badge badge-pill badge-primary" style="background-color: {{ ${badge_color} }};">{{ ${role} }}</span></td>
    <td>{{ ${tasks_assigned} }} Tasks</td>
    <td>{{ ${salary} }}</td>
    <td>
      <button type="button" class="btn btn-outline-primary">Update</button>
      <button type="button" class="btn btn-outline-danger">Delete</button>
      <button type="button" class="btn btn-outline-warning">Notify</button>
    </td>
  </tr>
    `;
}
export default userTableRow;