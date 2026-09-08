const chokidar = require('chokidar');
const path = require('path');
const { buildJs } = require('./build-js');

console.log('[JS] Starting JS watcher...');

// Initial build
buildJs();

const watchPaths = [
  path.resolve(__dirname, '../site/assets/js/**/*.js'),
  path.resolve(__dirname, '../site/components/**/*.js'),
];

let debounceTimer = null;
const watcher = chokidar.watch(watchPaths, {
  ignoreInitial: true,
  ignorePermissionErrors: true,
});

watcher.on('all', (event, filePath) => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    console.log(`[JS] File changed: ${path.basename(filePath)}, rebuilding JS...`);
    buildJs();
  }, 50);
});
