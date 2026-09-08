/*

  PAGE LOADER
  
*/

class Loader {
    constructor(onProgress, onComplete) {
        this.images = Array.from(document.querySelectorAll('img')).filter(img => img.src && !img.src.startsWith('data:'));
        this.total = this.images.length;
        this.loaded = 0;
        this.onProgress = onProgress || (() => {}); 
        this.onComplete = onComplete || (() => {});
    }

    init() {
        if (this.total === 0) {
            this.onComplete();
            return;
        }

        // Safety timeout so page never gets stuck
        const safetyTimer = setTimeout(() => {
            console.warn("Loader safety timeout triggered");
            this.onComplete();
        }, 2000);

        this.images.forEach(img => {
            if (img.complete && img.naturalWidth > 0) {
                const rect = img.getBoundingClientRect();
                img.style.setProperty('--w', `${rect.width}px`);
                img.style.setProperty('--h', `${rect.height}px`);
                this.updateProgress(safetyTimer);
                return;
            }

            const tempImage = new Image();
            tempImage.src = img.src;

            tempImage.onload = () => {
                const rect = img.getBoundingClientRect();
                img.style.setProperty('--w', `${rect.width || tempImage.naturalWidth}px`);
                img.style.setProperty('--h', `${rect.height || tempImage.naturalHeight}px`);
                this.updateProgress(safetyTimer);
            };

            tempImage.onerror = () => {
                this.updateProgress(safetyTimer);
            };
        });
    }

    updateProgress(safetyTimer) {
        this.loaded++;
        const percent = Math.min(Math.floor((this.loaded / this.total) * 100), 100);
        this.onProgress(percent);

        if (this.loaded >= this.total) {
            if (safetyTimer) clearTimeout(safetyTimer);
            this.onComplete();
        }
    }
}