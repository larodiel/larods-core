const { series, parallel } = require('gulp');
const { buildBlocksJs, buildBLocksCss }   = require('./tasks/buildBlocks');
const { buildAdminJs, buildAdminCss }   = require('./tasks/buildAdminAssets');
const { buildPublicJs, buildPublicCss }   = require('./tasks/buildPublicAssets');


exports.blocks = series(buildBlocksJs, buildBLocksCss);
exports.admin = series(buildAdminJs, buildAdminCss);
exports.public = series(buildPublicJs, buildPublicCss);
exports.default = parallel(buildBlocksJs, buildBLocksCss, buildAdminJs, buildAdminCss, buildPublicJs, buildPublicCss);
