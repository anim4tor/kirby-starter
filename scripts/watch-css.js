const chokidar = require('chokidar');
const path = require('path');
const { compileCss } = require('./build-css');

console.log('[CSS] Starting Sass watcher...');

// Initial build
compileCss();

// Watch only SCSS & CSS files
const watchPaths = [
  path.resolve(__dirname, '../site/**/*.scss'),
  path.resolve(__dirname, '../site/**/*.css'),
];

let debounceTimer = null;
const watcher = chokidar.watch(watchPaths, {
  ignoreInitial: true,
  ignorePermissionErrors: true,
});

watcher.on('all', (event, filePath) => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    console.log(`[CSS] File changed: ${path.basename(filePath)}, rebuilding CSS...`);
    compileCss();
  }, 50);
});
