const boilerPlate = (url) => {
    axios.get(url)
        .then(res => {
            const pagination = document.querySelector(".pagination");
            const response = res.data;
            console.log(response);
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

export default boilerPlate;