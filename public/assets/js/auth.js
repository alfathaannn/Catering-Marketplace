(function () {
    // elemen penting
    const tabLogin = document.getElementById("tabLogin");
    const tabRegister = document.getElementById("tabRegister");
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");
    const formTitle = document.getElementById("formTitle");
    const switchToRegister = document.getElementById("switchToRegister");
    const switchToLogin = document.getElementById("switchToLogin");
    const forgotLink = document.getElementById("forgotLink");
    const loginSubmit = document.getElementById("loginSubmit");
    const registerSubmit = document.getElementById("registerSubmit");
    const toast = document.getElementById("toast");
    const toastText = document.getElementById("toastText");
    const formWrapper = document.getElementById("formWrapper");

    // state aktif: true = login, false = register, check localstorage or hash to remember state (optional)
    let activeIsLogin = true;

    // Check if there are validation errors on the register form
    const hasRegisterErrors =
        registerForm.querySelectorAll(".invalid-feedback").length > 0;
    if (hasRegisterErrors || window.location.hash === "#register") {
        activeIsLogin = false;
    }

    // atur position absolute untuk wrapper agar sliding mulus
    gsap.set([loginForm, registerForm], {
        position: "absolute",
        top: 0,
        left: 0,
        width: "100%",
        opacity: 0,
        x: 30,
    });

    // Set initial state based on error validation
    if (activeIsLogin) {
        gsap.set(loginForm, { opacity: 1, x: 0, pointerEvents: "auto" });
        gsap.set(registerForm, { opacity: 0, x: 30, pointerEvents: "none" });
        tabLogin.classList.add("active");
        tabRegister.classList.remove("active");
        formTitle.innerText = "Login " + window.userRole;
    } else {
        gsap.set(registerForm, { opacity: 1, x: 0, pointerEvents: "auto" });
        gsap.set(loginForm, { opacity: 0, x: -30, pointerEvents: "none" });
        tabRegister.classList.add("active");
        tabLogin.classList.remove("active");
        formTitle.innerText = "Buat akun " + window.userRole;
    }

    // fungsi toast dengan icon
    window.showToast = function (text, isSuccess = true) {
        toastText.textContent = text;
        toast.classList.add("show");
        const iconSpan = toast.querySelector(".material-icons");
        iconSpan.textContent = isSuccess ? "check_circle" : "error";
        toast.style.border = isSuccess
            ? "1px solid var(--stone-700)"
            : "1px solid var(--blue-deep)";
        gsap.killTweensOf(toast);
        gsap.to(toast, {
            opacity: 1,
            scale: 1,
            duration: 0.2,
            ease: "power2.out",
        });
        gsap.delayedCall(3.5, () => {
            gsap.to(toast, {
                opacity: 0,
                scale: 0.9,
                duration: 0.2,
                onComplete: () => {
                    toast.classList.remove("show");
                },
            });
        });
    };

    // Check for Laravel flash messages
    if (window.flashErrors) {
        showToast(window.flashErrors, false);
    }
    if (window.flashSuccess) {
        showToast(window.flashSuccess, true);
    }

    // penyesuaian tinggi wrapper agar responsif terhadap tinggi form
    function adjustWrapperHeight() {
        const activeForm = activeIsLogin ? loginForm : registerForm;
        const height = activeForm.offsetHeight;
        gsap.to(formWrapper, {
            height: height,
            duration: 0.3,
            ease: "power2.inOut",
        });
    }

    // fungsi switch menggunakan GSAP slide + fade yang empuk
    window.switchToLoginPanel = function () {
        if (activeIsLogin) return;
        activeIsLogin = true;
        window.history.replaceState(null, null, " "); // remove hash

        // update tab
        tabLogin.classList.add("active");
        tabRegister.classList.remove("active");
        formTitle.innerText = "Login " + window.userRole;

        const tl = gsap.timeline({
            defaults: { duration: 0.45, ease: "power3.inOut" },
            onComplete: adjustWrapperHeight,
        });
        tl.to(loginForm, { opacity: 1, x: 0, pointerEvents: "auto" }, 0)
            .to(registerForm, { opacity: 0, x: -30, pointerEvents: "none" }, 0)
            // sedikit menggeser wrapper agar dinamis (opsional)
            .fromTo(formWrapper, {}, {}, 0);
    };

    window.switchToRegisterPanel = function () {
        if (!activeIsLogin) return;
        activeIsLogin = false;
        window.history.replaceState(null, null, "#register");

        tabRegister.classList.add("active");
        tabLogin.classList.remove("active");
        formTitle.innerText = "Buat akun " + window.userRole;

        const tl = gsap.timeline({
            defaults: { duration: 0.45, ease: "power3.inOut" },
            onComplete: adjustWrapperHeight,
        });
        tl.to(registerForm, { opacity: 1, x: 0, pointerEvents: "auto" }, 0).to(
            loginForm,
            { opacity: 0, x: 30, pointerEvents: "none" },
            0,
        );
    };

    // event listeners
    tabLogin.addEventListener("click", (e) => {
        e.preventDefault();
        switchToLoginPanel();
    });
    tabRegister.addEventListener("click", (e) => {
        e.preventDefault();
        switchToRegisterPanel();
    });
    switchToRegister.addEventListener("click", (e) => {
        e.preventDefault();
        switchToRegisterPanel();
    });
    switchToLogin.addEventListener("click", (e) => {
        e.preventDefault();
        switchToLoginPanel();
    });

    if (forgotLink) {
        forgotLink.addEventListener("click", (e) => {
            e.preventDefault();
            showToast("Fitur reset password segera hadir", false);
        });
    }

    // Animate button clicks
    loginForm.addEventListener("submit", () => {
        gsap.timeline()
            .to(loginSubmit, { scale: 1.04, duration: 0.1 })
            .to(loginSubmit, { scale: 0.98, duration: 0.1 })
            .to(loginSubmit, { scale: 1, duration: 0.1 });
    });

    registerForm.addEventListener("submit", () => {
        gsap.timeline()
            .to(registerSubmit, { scale: 1.04, duration: 0.1 })
            .to(registerSubmit, { scale: 0.98, duration: 0.1 })
            .to(registerSubmit, { scale: 1, duration: 0.1 });
    });

    // animasi awal load
    gsap.fromTo(
        ".auth-card",
        { opacity: 0, y: 30 },
        { opacity: 1, y: 0, duration: 0.8, ease: "power3.out", delay: 0.1 },
    );

    // input group animasi bertahap (stagger)
    const activeFormSelector = activeIsLogin
        ? "#loginForm .input-group"
        : "#registerForm .input-group";
    gsap.fromTo(
        activeFormSelector,
        { opacity: 0, x: -10 },
        {
            opacity: 1,
            x: 0,
            duration: 0.5,
            stagger: 0.07,
            ease: "power2.out",
            delay: 0.3,
        },
    );

    // toggle visibility password
    const togglePasswordIcons = document.querySelectorAll(".toggle-password");
    togglePasswordIcons.forEach((icon) => {
        icon.addEventListener("click", function () {
            const targetId = this.getAttribute("data-target");
            const inputElement = document.getElementById(targetId);

            if (inputElement.type === "password") {
                inputElement.type = "text";
                this.textContent = "visibility";
                this.style.color = "var(--blue-deep)";
            } else {
                inputElement.type = "password";
                this.textContent = "visibility_off";
                this.style.color = "var(--stone-300)";
            }

            // animasi scale click kecil pada icon
            gsap.fromTo(
                this,
                { scale: 0.8 },
                { scale: 1, duration: 0.2, ease: "back.out(2)" },
            );
        });
    });

    // initial adjust
    setTimeout(adjustWrapperHeight, 100);
    window.addEventListener("resize", adjustWrapperHeight);
})();
