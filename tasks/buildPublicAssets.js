const { src, dest } = require('gulp');
const babel = require('gulp-babel');
const eslint = require('gulp-eslint-new');
const postcss = require('gulp-postcss');
const cssnano = require('cssnano');
const postcssNested = require('postcss-nested');
const postcssImport = require('postcss-import');
const uglify = require('gulp-uglify-es').default;
const concat = require('gulp-concat');

module.exports = {
  buildPublicJs(cb) {
    return src('./src/public/scripts/*.js')
      .pipe(eslint.format())
      .pipe(eslint.failAfterError())
      .pipe(babel({
        presets: ["@wordpress/babel-preset-default", "@babel/preset-env"]
      }))
      .pipe(uglify())
      .pipe(concat('larods-core.min.js'))
      .pipe(dest('./dist/public/scripts'))
    cb();
  },
  buildPublicCss(cb) {
    return src('./src/public/styles/*.css')
          .pipe(postcss([cssnano(), postcssNested(), postcssImport()]))
          .pipe(dest(`./dist/public/styles`))
    cb();
  }
};
