const guestbook = document.querySelectorAll('.tx-ns-guestbook');
if (guestbook.length) {

    const paginateLinks = document.querySelectorAll(".paginate");
    var products = document.querySelector('.comments-list');
    var paginationClass = document.querySelector(".pagination-load-wrap");

    const paginate = function (event) {
        event.preventDefault();

        let url = this.getAttribute("href");

        fetch(url, {
            method: 'GET',
        }).then((resp) => {
            return resp.text();
        }).then((html) => {

            let parser = new DOMParser();
            let doc = parser.parseFromString(html, "text/html");

            // Get the new items
            let filterProducts = doc.querySelector('.comments-list').innerHTML;
            // Render the items
            products.innerHTML = filterProducts;

            // Get pagiantion section
            let pagination = doc.querySelector('.pagination-load-wrap').innerHTML;
            // Replace new HTML
            paginationClass.innerHTML = pagination;

            // Assign click event
            let pageBtns = paginationClass.querySelectorAll('.paginate');
            if (pageBtns.length > 0) {
                for (let j = 0; j < pageBtns.length; j++) {
                    pageBtns[j].addEventListener('click', paginate, false);

                }
            }
        }).catch((error) => {
        });

    };

    if (paginateLinks.length > 0) {
        for (let i = 0; i < paginateLinks.length; i++) {
            paginateLinks[i].addEventListener('click', paginate, false);

        }
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('guestbookForm');
    form.addEventListener('submit', function(event) {
            // Find the submit button by class name
            const submitButton = form.querySelector('.ns-btn.submit');
            if (submitButton) {
                    submitButton.disabled = true; 
                    submitButton.value = 'Submitting...'; 
            }
    });
});