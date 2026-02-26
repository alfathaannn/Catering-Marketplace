// DOM Elements
const sidebar = document.getElementById("sidebar");
const menuToggle = document.getElementById("menu-toggle");
const mobileOverlay = document.getElementById("mobile-overlay");
const selectAllCheckbox = document.getElementById("selectAll");
const rowCheckboxes = document.querySelectorAll("tbody .custom-checkbox");

// Sidebar Toggle Logic
function toggleSidebar() {
    if (sidebar) sidebar.classList.toggle("open");
    if (mobileOverlay) mobileOverlay.classList.toggle("active");
}

if (menuToggle) {
    menuToggle.addEventListener("click", toggleSidebar);
}
if (mobileOverlay) {
    mobileOverlay.addEventListener("click", toggleSidebar);
}

// Select All Checkbox Logic
if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener("change", (e) => {
        rowCheckboxes.forEach((cb) => {
            cb.checked = e.target.checked;
        });
    });
}

// Individual checkbox check logic to update "Select All" status
if (selectAllCheckbox && rowCheckboxes.length > 0) {
    rowCheckboxes.forEach((cb) => {
        cb.addEventListener("change", () => {
            const allChecked = Array.from(rowCheckboxes).every(
                (c) => c.checked,
            );
            const someChecked = Array.from(rowCheckboxes).some(
                (c) => c.checked,
            );
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
        });
    });
}

// --------------------------------------------------------
// GSAP Animations Engine
// --------------------------------------------------------
document.addEventListener("DOMContentLoaded", () => {
    // Wait a brief moment to simulate loading or just until ready
    setTimeout(() => {
        // Fade out loader
        gsap.to("#loader", {
            opacity: 0,
            duration: 0.001,
            ease: "power3.out",
            onComplete: () => {
                document.getElementById("loader").style.display = "none";
                triggerEntranceAnimations();
            },
        });
    }, 300);

    function triggerEntranceAnimations() {
        // Create a master timeline
        const tl = gsap.timeline();

        // 1. Sidebar Elements
        tl.fromTo(
            ".gs-reveal",
            { opacity: 0, x: -20 },
            {
                opacity: 1,
                x: 0,
                duration: 0.5,
                stagger: 0.1,
                ease: "power3.out",
            },
        );

        tl.fromTo(
            ".gs-item",
            { opacity: 0, x: -15 },
            {
                opacity: 1,
                x: 0,
                duration: 0.4,
                stagger: 0.05,
                ease: "power2.out",
            },
            "-=0.3",
        );

        // 2. Topbar and Header Title
        tl.fromTo(
            ["#topbar", ".gs-title"],
            { opacity: 0, y: -20 },
            {
                opacity: 1,
                y: 0,
                duration: 0.6,
                stagger: 0.15,
                ease: "power3.out",
            },
            "-=0.6",
        );

        // 3. Stats Cards (Staggered bounce up)
        tl.fromTo(
            ".gs-card",
            { opacity: 0, y: 40, scale: 0.95 },
            {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 0.7,
                stagger: 0.1,
                ease: "back.out(1.4)",
            },
            "-=0.4",
        );

        // 4. Table Wrapper
        tl.fromTo(
            ".gs-table-wrapper",
            { opacity: 0, y: 30 },
            { opacity: 1, y: 0, duration: 0.6, ease: "power3.out" },
            "-=0.4",
        );

        // 5. Table Rows Stagger
        tl.fromTo(
            ".gs-row",
            { opacity: 0, x: -20 },
            {
                opacity: 1,
                x: 0,
                duration: 0.4,
                stagger: 0.08,
                ease: "power2.out",
            },
            "-=0.3",
        );

        // 6. Pagination
        tl.fromTo(
            ".gs-pagination",
            { opacity: 0 },
            { opacity: 1, duration: 0.4 },
            "-=0.2",
        );
    }

    // Subtle interactive animations
    const buttons = document.querySelectorAll(
        ".btn-primary, .btn-secondary, .icon-btn",
    );
    buttons.forEach((btn) => {
        btn.addEventListener("mousedown", () => {
            gsap.to(btn, { scale: 0.95, duration: 0.1 });
        });
        btn.addEventListener("mouseup", () => {
            gsap.to(btn, { scale: 1, duration: 0.2, ease: "back.out(2)" });
        });
        btn.addEventListener("mouseleave", () => {
            gsap.to(btn, { scale: 1, duration: 0.2 });
        });
    });

    // Row hover interaction
    const rows = document.querySelectorAll(".gs-row");
    rows.forEach((row) => {
        row.addEventListener("mouseenter", () => {
            gsap.to(row, {
                backgroundColor: "var(--off-white)",
                duration: 0.2,
            });
        });
        row.addEventListener("mouseleave", () => {
            gsap.to(row, { backgroundColor: "transparent", duration: 0.2 });
        });
    });
});
