const paginationTemplate = (link, name, active) => {
    return `<li class="page-item"><a class="page-link ${ (!link) ? "disabled-link" : "" } ${ (active) ? "active-page" : "" }" data-href="${link}" onclick="getPaginationData('${link}')">${name}</a></li>`;
}
export default paginationTemplate;