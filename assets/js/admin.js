document.addEventListener("DOMContentLoaded", function () {
    let path = window.location.pathname.split("/").pop();
    if (path === '' || path === 'admin') path = 'index.php';

    const menuLinks = document.querySelectorAll(".sidebar .menu a");

    menuLinks.forEach(link => {
        const href = link.getAttribute("href").split("/").pop();

        if (href === path) {
            document.querySelectorAll('.sidebar .menu li').forEach(item => {
                item.classList.remove('active');
            });

            const parentLi = link.closest('li');
            if (parentLi) {
                parentLi.classList.add('active');
            }
        }
    });
});