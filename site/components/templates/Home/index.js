// const slides = document.querySelectorAll('[intro-slider] [slide]');
// let currentIndex = 0;

// function nextSlide() {
//   // Remove active class from current
//   slides[currentIndex].classList.remove('is-active');
  
//   // Move to next index
//   currentIndex = (currentIndex + 1) % slides.length;
  
//   // Add active class to next
//   setTimeout(function() {
//     slides[currentIndex].classList.add('is-active');
//   },500)
// }

// // Initialize first slide and start interval
// setTimeout(function() {
//   slides[0].classList.add('is-active');
//   setInterval(nextSlide, 5000); // Changes every 3 seconds
// },400)