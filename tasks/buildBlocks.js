const { src, dest } = require('gulp');
const babel = require('gulp-babel');
const eslint = require('gulp-eslint-new');
const postcss = require('gulp-postcss');
const cssnano = require('cssnano');
const postcssNested = require('postcss-nested');
const postcssImport = require('postcss-import');
const uglify = require('gulp-uglify-es').default;
const concat = require('gulp-concat');
const flatmap = require('gulp-flatmap');
const path = require('path');

function getBlockFolder(file) {
  let blockFolder = file.path.match(/blocks\/([\w]+)/);
  if(blockFolder) {
    return blockFolder = blockFolder[0];
  }
  return '';
}

module.exports = {
  buildBlocksJs(cb) {
    return src('./blocks/**/src/scripts/*.js', { base: './' })
          .pipe(flatmap((stream, file) => {
            const blockFolder = getBlockFolder(file);

            return src(`${file.dirname}/*.js`)
              .pipe(eslint.format())
              .pipe(eslint.failAfterError())
              .pipe(babel({
                presets: ["@wordpress/babel-preset-default", "@babel/preset-env"]
              }))
              .pipe(uglify())
              .pipe(concat('block.min.js'))
              .pipe(dest(`./${blockFolder}/dist/scripts`))
          }));
    cb();
  },
  buildBLocksCss(cb) {
    return src('./blocks/**/src/styles/*.css', { base: './' })
          .pipe(flatmap((stream, file) => {
            const blockFolder = getBlockFolder(file);

            return src(`${file.dirname}/*.css`)
              .pipe(postcss([cssnano(), postcssNested(), postcssImport()]))
              .pipe(dest(`./${blockFolder}/dist/styles`))
          }));
    cb();
  }
};
