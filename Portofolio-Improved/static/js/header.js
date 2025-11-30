const loadPartial = (targetId, path) => {
    const el = document.getElementById(targetId);
    if (!el) return;
    fetch(path)
        .then(res => res.text())
        .then(html => { el.innerHTML = html; })
        .catch(err => console.error(`${path} load failed`, err));
};

document.addEventListener('DOMContentLoaded', () => {
    loadPartial('header-container', 'partials/header.html');
    loadPartial('footer-container', 'partials/footer.html');
});
