document.addEventListener("DOMContentLoaded", function () {
  const paragraphs = document.querySelectorAll(".about-hostel p");
  paragraphs.forEach((p) => {
    setTimeout(() => {
      p.classList.add("show");
    }, 100);
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const animateItems = document.querySelectorAll(".animate-item");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("show");
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.2 }
  );

  animateItems.forEach((item) => observer.observe(item));
});

document.addEventListener("DOMContentLoaded", function() {
    const animateItems = document.querySelectorAll(".animate-item");
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if(entry.isIntersecting){
                entry.target.classList.add("show");
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    animateItems.forEach(item => observer.observe(item));
});

document.addEventListener("DOMContentLoaded", function() {
    const animateItems = document.querySelectorAll(".animate-item");
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if(entry.isIntersecting){
                entry.target.classList.add("show");
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    animateItems.forEach(item => observer.observe(item));
});

document.addEventListener("DOMContentLoaded", function() {
    const animateItems = document.querySelectorAll(".animate-item");
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if(entry.isIntersecting){
                entry.target.classList.add("show");
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    animateItems.forEach(item => observer.observe(item));
});

document.addEventListener("DOMContentLoaded", function() {
    const animateItems = document.querySelectorAll(".animate-item");
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if(entry.isIntersecting){
                entry.target.classList.add("show");
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    animateItems.forEach(item => observer.observe(item));
});
