const PartnersSectionInHomePage = document.querySelector(".our-partners-home");
window.addEventListener("scroll",(_)=>{
    if (window.scrollY + 500 >= PartnersSectionInHomePage.offsetTop ){
        const counters = document.querySelectorAll('.count');
        const speed = 800;
        counters.forEach( counter => {
            const animate = () => {
                const value = +counter.getAttribute('data-target');
                const data = +counter.innerText;

                const time = value / speed;
                if(data < value) {
                    counter.innerText = Math.ceil(data + time);
                    setInterval(animate, 1000);
                }else{
                    counter.innerText = value;
                }
            }
            animate();
        });
    }
})
