

/**sliding**/

document.addEventListener("DOMContentLoaded", () => {
  const sections = document.querySelectorAll(".slide-section");

  // Add alternating classes for sliding directions
  sections.forEach((section, index) => {
    if (index % 2 === 0) {
      section.classList.add("slide-left");
    } else {
      section.classList.add("slide-right");
    }
  });

  // Intersection Observer to trigger animation
  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
        observer.unobserve(entry.target); // Stop observing after animation
      }
    });
  }, { threshold: 0.1 }); // Trigger when 10% is visible

  sections.forEach((section) => observer.observe(section));
});
