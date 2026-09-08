/**
 * Preloads images specified by the CSS selector.
 * @function
 * @param {string} [selector='img'] - CSS selector for target images.
 * @returns {Promise} - Resolves when all specified images are loaded.
 */


const preloadImages = (selector = 'img') => {
  return new Promise((resolve) => {
      let counter = 0,
          len = document.querySelectorAll(selector).length
      // The imagesLoaded library is used to ensure all images (including backgrounds) are fully loaded.
      const preload = imagesLoaded(document.querySelectorAll(selector), {background: true}, resolve);
      preload.on( 'progress', function( instance, image ) {
        // image.img.hasAttribute('data-preload') ? counter++ : null;
        counter++;
        var percentImg = counter / len * 100
        var progress = percentImg/100
        console.log( percentImg.toFixed(0) );
        document.querySelector('[data-loader]').style.setProperty('--progress', progress );
        // document.querySelector('[data-counter]').innerHTML = percentImg.toFixed(0).toString().padStart(1, "0") + '%'
        // document.querySelector('[data-loader-img]').src = image.img.src
      });
  });
};

// Exporting utility functions for use in other modules.
// export {
//   preloadImages
// };