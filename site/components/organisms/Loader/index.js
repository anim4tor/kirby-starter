/*

  PAGE LOADER
  
*/

class Loader {
    constructor(onProgress, onComplete) {
        console.log("Loading: 0%");
        this.images = Array.from(document.querySelectorAll('img'));
        this.total = this.images.length;
        this.loaded = 0;
        this.onProgress = onProgress || (() => {}); 
        this.onComplete = onComplete || (() => {});
    }

    // init() {
    //     if (this.total === 0) return this.onComplete();

    //     this.images.forEach(img => {
    //         // Check if image is already complete (cached)
    //         if (img.complete) {
    //             this.updateProgress();
    //         } else {
    //             img.addEventListener('load', () => this.updateProgress());
    //             img.addEventListener('error', () => this.updateProgress());
    //         }
    //     });
    // }

    init() {
        if (this.total === 0) {
            this.onComplete();
            return;
        }

        this.images.forEach(img => {
            const tempImage = new Image();
            tempImage.src = img.src;

            tempImage.onload = () => {
                // 1. Capture the true dimensions from the loaded file
                // const width = tempImage.naturalWidth;
                // const height = tempImage.naturalHeight;

                const rect = img.getBoundingClientRect();
                const width = rect.width;
                const height = rect.height;

                // 2. Apply those dimensions to the original DOM element
                // This prevents layout shift and informs your CSS
                img.width = width;
                img.height = height;

                // 2. Set CSS Variables on the specific image element
                // We append 'px' so you can use them directly in calculations
                img.style.setProperty('--w', `${width}px`);
                img.style.setProperty('--h', `${height}px`);

                this.updateProgress();
            };

            tempImage.onerror = () => {
                console.warn(`Failed to load: ${img.src}`);
                this.updateProgress();
            };
        });
    }

    updateProgress() {
        this.loaded++;
        const percent = Math.min(Math.floor((this.loaded / this.total) * 100), 100);
        console.clear();
        console.log(`Loading: ${percent}%`);
        this.onProgress(percent);

        if (this.loaded === this.total) {
            this.onComplete();
        }
    }
}