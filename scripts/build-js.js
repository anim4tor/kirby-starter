const fs = require('fs');
const path = require('path');
const esbuild = require('esbuild');

const isMinify = process.argv.includes('--minify');
const inputFile = path.resolve(__dirname, '../site/assets/js/app.js');
const outputFile = path.resolve(__dirname, '../public/assets/js/app.dist.js');

function resolveImports(filePath, visited = new Set()) {
  const absolutePath = path.resolve(filePath);
  if (visited.has(absolutePath)) return { prependedCode: '', mainCode: '', watchedFiles: [] };
  visited.add(absolutePath);

  const fileDir = path.dirname(absolutePath);
  const content = fs.readFileSync(absolutePath, 'utf8');
  const watchedFiles = [absolutePath];

  let prependedCode = '';
  let mainCode = '';

  const lines = content.split(/\r?\n/);
  for (const line of lines) {
    const importMatch = line.match(/^\s*import\s+['"](.+?)['"];?/) ||
                        line.match(/^\s*\/\/\s*@prepros-prepend\s+['"]?(.+?)['"]?\s*$/);

    if (importMatch) {
      const relativeImport = importMatch[1].trim();
      const resolvedPath = path.resolve(fileDir, relativeImport);
      if (fs.existsSync(resolvedPath)) {
        const sub = resolveImports(resolvedPath, visited);
        prependedCode += sub.prependedCode + '\n' + sub.mainCode + '\n';
        watchedFiles.push(...sub.watchedFiles);
      } else {
        console.warn(`[JS Warn] Could not resolve import: ${relativeImport} in ${filePath}`);
      }
    } else {
      mainCode += line + '\n';
    }
  }

  return { prependedCode, mainCode, watchedFiles };
}

function buildJs() {
  const startTime = Date.now();
  try {
    const { prependedCode, mainCode, watchedFiles } = resolveImports(inputFile);
    const combinedCode = prependedCode + '\n' + mainCode;

    const transformed = esbuild.transformSync(combinedCode, {
      minify: isMinify,
      target: 'es2020',
    });

    const outputDir = path.dirname(outputFile);
    if (!fs.existsSync(outputDir)) {
      fs.mkdirSync(outputDir, { recursive: true });
    }

    fs.writeFileSync(outputFile, transformed.code);
    const duration = Date.now() - startTime;
    console.log(`[JS] Compiled in ${duration}ms -> public/assets/js/app.dist.js`);
    return watchedFiles;
  } catch (err) {
    console.error(`[JS Error]`, err.message || err);
    return [];
  }
}

if (require.main === module) {
  buildJs();
}

module.exports = { buildJs, resolveImports };
