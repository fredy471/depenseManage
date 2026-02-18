(() => {
    const STORAGE_KEY = "theme";
    const root = document.documentElement;

    function applyTheme(theme) {
        root.setAttribute("data-theme", theme);
        const btn = document.getElementById("themeToggle");
        if (btn) {
            const isLight = theme === "light";
            btn.textContent = isLight ? "Mode sombre" : "Mode clair";
            btn.setAttribute("aria-pressed", String(isLight));
        }
    }

    function getInitialTheme() {
        const saved = localStorage.getItem(STORAGE_KEY);
        if (saved === "light" || saved === "dark") return saved;
        return window.matchMedia("(prefers-color-scheme: light)").matches ? "light" : "dark";
    }

    document.addEventListener("DOMContentLoaded", () => {
        applyTheme(getInitialTheme());
        const btn = document.getElementById("themeToggle");
        if (!btn) return;

        btn.addEventListener("click", () => {
            const next = root.getAttribute("data-theme") === "light" ? "dark" : "light";
            localStorage.setItem(STORAGE_KEY, next);
            applyTheme(next);
        });
    });
})();

