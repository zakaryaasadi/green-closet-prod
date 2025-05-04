// let workingSteps = document.querySelectorAll(".container-box"),

howWeWorkSecions = document.querySelectorAll('.how-we-work')

howWeWorkSecions.forEach((section, index) => {
    section.classList.add(`how-we-work-${index + 1}`)
    const imageStep = document.querySelectorAll(`.how-we-work-${index + 1} .image-container`);



    const workingSteps = document.querySelectorAll(`.how-we-work-${index + 1} .container-box`)
    workingSteps.forEach((ele) => {
        ele.addEventListener("click",
            () => {
            console.log("sdasdasdasdasd")
                var getWorkingStepsDataImageSrc = ele.getAttribute("data-image-src");
                imageStep.forEach(image =>{
                    image.style.backgroundImage = `url("${getWorkingStepsDataImageSrc}")`
                })

            })
    })

})




