
let loaderElements = document.querySelectorAll(".scene *")
scene=document.querySelector(".scene");
let stateCheck = setInterval(() => {
    if (document.readyState === 'complete') {
        clearInterval(stateCheck);
        loaderElements.forEach(ele=>{
            ele.classList.add("slide-out-bck-center")
        })

        setTimeout(()=>{
            scene.classList.add("opacity-0")
            scene.remove();
        },800)
    }

}, 100);


