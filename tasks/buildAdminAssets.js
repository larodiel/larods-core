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
  buildAdminJs(cb) {
    return src('./src/admin/scripts/*.js')
      .pipe(eslint.format())
      .pipe(eslint.failAfterError())
      .pipe(babel({
        presets: ["@wordpress/babel-preset-default", "@babel/preset-env"]
      }))
      .pipe(uglify())
      .pipe(concat('larods-core.min.js'))
      .pipe(dest('./dist/admin/scripts'))
    cb();
  },
  buildAdminCss(cb) {
    return src('./src/admin/styles/*.css')
          .pipe(postcss([cssnano(), postcssNested(), postcssImport()]))
          .pipe(dest(`./dist/admin/styles`))
    cb();
  }
};
