// Wait for the DOM to fully load before running the scripts
document.addEventListener("DOMContentLoaded", function () {
  // Header scroll functionality
  const header = document.querySelector(".main-header");

  if (header) {
    window.addEventListener("scroll", () => {
      if (window.scrollY > 0) {
        header.classList.add("fixed-header");
      } else {
        header.classList.remove("fixed-header");
      }
    });
  }

  // Menu toggle functionality
  function toggleMenu() {
    const hamburger = document.querySelector(".hamburger");
    const navMenu = document.querySelector(".main-header-nav ul");
    const overlay = document.querySelector(".menu-overlay");

    if (hamburger && navMenu) {
      hamburger.classList.toggle("open");
      navMenu.classList.toggle("show");
      overlay.classList.toggle("active");
    }
  }

  // Attach toggleMenu to hamburger click event
  const hamburger = document.querySelector(".hamburger");
  if (hamburger) {
    hamburger.addEventListener("click", toggleMenu);
  }

  // Carousel text functionality
  const carouselText = document.querySelector(".carousel-text");
  const messages = [
    "Get an electrician in a minute ",
    "Find electricians quick quick",
    "Gba Amọlẹ laarin iṣẹju kan ",
    "Nweta ọkụ n'ime otu nkeji ",
    "Samu wutar lantarki cikin minti daya",
  ];

  if (carouselText) {
    let currentIndex = 0;

    function updateText() {
      carouselText.style.opacity = "0";
      carouselText.style.transform = "translateY(100%)";

      setTimeout(() => {
        currentIndex = (currentIndex + 1) % messages.length;
        carouselText.textContent = messages[currentIndex];
        carouselText.style.opacity = "1";
        carouselText.style.transform = "translateY(0)";
      }, 500);
    }

    setInterval(updateText, 3000);
  }

  // Counter functionality
  const counters = document.querySelectorAll(".count");

  if (counters.length > 0) {
    counters.forEach(counter => {
      const target = +counter.getAttribute("data-target");
      let count = 0;
      const increment = Math.ceil(target / 100);

      function updateCounter() {
        count += increment;
        if (count > target) count = target;
        counter.textContent = count; // Update only the number
        if (count < target) {
          requestAnimationFrame(updateCounter);
        }
      }

      updateCounter();
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const grids = document.querySelectorAll(
    ".header-card-two-grid-one, .header-card-two-grid-two"
  );

  function startScrolling() {
    grids.forEach((grid, index) => {
      const images = Array.from(grid.querySelectorAll("img"));
      const totalImages = images.length;

      // Calculate accurate image height including margins
      const imageHeight =
        images[0].offsetHeight +
        parseInt(getComputedStyle(images[0]).marginBottom);

      // Clone images only if not already cloned
      if (!grid.querySelector(".cloned")) {
        images.forEach((image) => {
          const clone = image.cloneNode(true);
          clone.classList.add("cloned");
          grid.appendChild(clone);
        });
      }

      let position = 0;
      const speed = 2; // Scrolling speed
      const delayTime = index === 0 ? 0 : 2000;

      function scrollImages() {
        position -= speed; // Move the grid upward
        grid.style.transform = `translateY(${position}px)`;

        // Check if we reached the end and reset smoothly
        if (Math.abs(position) >= imageHeight * totalImages) {
          grid.style.transition = "none"; // Remove transition for reset
          position = 0;
          grid.style.transform = `translateY(${position}px)`;
          grid.offsetHeight; // Trigger reflow to apply changes
          grid.style.transition = "transform 0.2s linear"; // Reapply transition
        }

        requestAnimationFrame(scrollImages); // Continue scrolling
      }

      setTimeout(() => {
        requestAnimationFrame(scrollImages);
      }, delayTime);
    });
  }

  function checkMediaQuery() {
    if (window.innerWidth > 984) {
      startScrolling();
    } else {
      grids.forEach((grid) => {
        grid.style.transform = "translateY(0)";
      });
    }
  }

  // Run on load
  checkMediaQuery();

  // Add a listener for window resize to dynamically adjust behavior
  window.addEventListener("resize", checkMediaQuery);
});