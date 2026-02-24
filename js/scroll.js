const scrollElementos = document.querySelectorAll(".scroll-reveal");

const elementInView = (el, offset = 100) => {
  const elementTop = el.getBoundingClientRect().top;
  return (
    elementTop <= (window.innerHeight || document.documentElement.clientHeight) - offset
  );
};

const displayScrollElement = (element) => {
  element.classList.add("active");
};

const hideScrollElement = (element) => {
  element.classList.remove("active");
};

const handleScrollAnimation = () => {
  scrollElementos.forEach((el) => {
    if (elementInView(el, 100)) {
      displayScrollElement(el);
    } else {
      hideScrollElement(el);
    }
  });
};

window.addEventListener("scroll", () => {
  handleScrollAnimation();
});

window.addEventListener("load", () => {
  handleScrollAnimation();
});