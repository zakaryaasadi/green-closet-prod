const header = window.header,
    mainSection = document.querySelector("main")


if (window.innerWidth >= 1200) {
    window.addEventListener('scroll', (event) => {
        if (window.scrollY >= 10) {
            header.classList.add("blink-1");
            mainSection.style.paddingTop = `${header.offsetHeight}px`
        } else {
            mainSection.style.paddingTop = "0px"
            header.classList.remove("blink-1");
        }
    });
} else {
    document.addEventListener("DOMContentLoaded", function () {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 150) {
                header.classList.add('sticky-top-main');
                document.body.style.paddingTop = '0';
            } else {
                header.classList.remove('sticky-top-main');
                document.body.style.paddingTop = '0';
            }

        });
        mainSection.style.paddingTop = header.offsetHeight

    });
}
let loaderElements = document.querySelectorAll(".scene *")
scene = document.querySelector(".scene");
    let stateCheck = setInterval(() => {
        if (document.readyState === 'complete') {
            clearInterval(stateCheck);
            loaderElements.forEach(ele => {
                ele.classList.add("slide-out-bck-center")
            })

            setTimeout(() => {
                scene.classList.add("opacity-0")
                scene.remove();
            }, 800)
        }

    }, 100);



