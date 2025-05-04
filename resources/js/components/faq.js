let d = document,
    accordionToggles = d.querySelectorAll('.js-accordionTrigger'),
    setAria,
    setAccordionAria,
    switchAccordion,
    touchSupported = ('ontouchstart' in window),
    pointerSupported = ('pointerdown' in window),
    skipClickDelay;

skipClickDelay = function (e) {
    e.preventDefault();
    e.target.click();
}

setAriaAttr = function (el, ariaType, newProperty) {
    el.setAttribute(ariaType, newProperty);
};

setAccordionAria = function (el1, el2, expanded) {
    switch (expanded) {
        case "true":
            setAriaAttr(el1, 'aria-expanded', 'true');
            setAriaAttr(el2, 'aria-hidden', 'false');
            break;
        case "false":
            setAriaAttr(el1, 'aria-expanded', 'false');
            setAriaAttr(el2, 'aria-hidden', 'true');
            break;
        default:
            break;
    }
};

switchAccordion = function (e) {
    e.preventDefault();

    let thisAnswer = e.target.parentNode.nextElementSibling,
        thisQuestion = e.target;

    // Close all accordions first
    let allAccordionItems = d.querySelectorAll('.accordionItem');
    for (let i = 0; i < allAccordionItems.length; i++) {
        setAccordionAria(accordionToggles[i], allAccordionItems[i], 'false');
        allAccordionItems[i].classList.add('is-collapsed');
        allAccordionItems[i].classList.remove('is-expanded', 'animateIn');
        accordionToggles[i].classList.remove('is-expanded');
    }

    // Open the clicked accordion
    setAccordionAria(thisQuestion, thisAnswer, 'true');
    thisQuestion.classList.remove('is-collapsed');
    thisQuestion.classList.add('is-expanded');
    thisAnswer.classList.remove('is-collapsed');
    thisAnswer.classList.add('is-expanded', 'animateIn');
    thisQuestion.classList.add('is-expanded');
};

for (let i = 0, len = accordionToggles.length; i < len; i++) {
    if (touchSupported) {
        accordionToggles[i].addEventListener('touchstart', skipClickDelay, false);
    }
    if (pointerSupported) {
        accordionToggles[i].addEventListener('pointerdown', skipClickDelay, false);
    }
    accordionToggles[i].addEventListener('click', switchAccordion, false);
}
