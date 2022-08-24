const { series, parallel, src, dest } = require('gulp');
const { buildBlocksJs, buildBLocksCss } = require('./tasks/buildBlocks');
const { buildAdminJs, buildAdminCss } = require('./tasks/buildAdminAssets');
const { buildPublicJs, buildPublicCss } = require('./tasks/buildPublicAssets');

exports.blocks = series(buildBlocksJs, buildBLocksCss);
exports.admin = series(buildAdminJs, buildAdminCss);
exports.public = series(buildPublicJs, buildPublicCss);
exports.default = parallel(
  buildBlocksJs,
  buildBLocksCss,
  buildAdminJs,
  buildAdminCss,
  buildPublicJs,
  buildPublicCss
);
exports.zip = function () {
  const zip = require('gulp-zip');
  return src([
    './**/',
    './**/*.*',
    '!./blocks/**/src/**',
    '!./src/**',
    '!./tasks/**',
    '!./cache/**',
    '!./node_modules/**',
    '!./package.json',
    '!./package-lock.json',
    '!./.babelrc',
    '!./.eslintrc.js',
    '!./*.zip',
    '!./.gitignore.js',
    '!./.stylelintrc.js',
    '!./gulpfile.js',
  ])
    .pipe(zip('larods-core.zip'))
    .pipe(dest('./'));
};
