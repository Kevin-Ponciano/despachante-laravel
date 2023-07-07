let themeStorageKey = "theme";
let defaultTheme = "light";
let selectedTheme = localStorage.getItem(themeStorageKey);

if (selectedTheme === null) {
    localStorage.setItem(themeStorageKey, defaultTheme);
    selectedTheme = defaultTheme;
}
if (selectedTheme === 'dark') {
    document.body.setAttribute("data-bs-theme", selectedTheme);
} else {
    document.body.removeAttribute("data-bs-theme");
}

$('document').ready(function () {
    $('.hide-theme-dark').on('click', function () {
        localStorage.setItem(themeStorageKey, 'dark');
        document.body.setAttribute("data-bs-theme", 'dark');
    });
    $('.hide-theme-light').on('click', function () {
        localStorage.setItem(themeStorageKey, 'light');
        document.body.removeAttribute("data-bs-theme");
    });
});
