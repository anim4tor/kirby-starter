const element = document.querySelector('.cta');

element.addEventListener('mousemove', (e) => {
  // Get the element's bounding rectangle to find its position on the page
  const rect = element.getBoundingClientRect();
  
  // Calculate horizontal distance from the left edge of the element
  const x = e.clientX - rect.left;
  
  // Calculate ratio: 0 (left edge) to 1 (right edge)
  const ratio = Math.max(0, Math.min(1, x / rect.width));
  
  // Set the CSS variable
  element.style.setProperty('--x', ratio);
});