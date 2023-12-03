import paginationTemplate from "./paginationTemplate.js";
import debounce from "./debounce.js";

const getUsers = (url) => {
axios.get(url)
    .then(res => {
        const pagination = document.querySelector(".pagination");
        const response = res.data;
        const links = response.links;
        console.log(links)
        let linkMarkup = "";
        links.forEach(link => {
            linkMarkup += paginationTemplate(link.url, link.label, link.active);
        })
        pagination.innerHTML = linkMarkup;
        
    })
    .catch(err => {
        console.log(err)
    })
}

const search = document.getElementById("search");
const test = debounce(() => {
    getUsers(`/api/users/get?keyword=${search.value}`);
}, 500)
search.addEventListener("keyup", test)
getUsers("/api/users/get");
export default getUsers;