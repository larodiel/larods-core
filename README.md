# Larods Core
This WordPress plugin is commonly used to do freelancers to avoid that the clients mess with the code added even if they update/change the theme.

### Tools

This plugin uses the follow tools.
- [Gulp](https://gulpjs.com/) - Builder/Task Manager
- [Twig](https://twig.symfony.com/doc/3.x/) - Template engine
- [Babel](https://babeljs.io/) - To build WP Blocks
- [PostCSS](https://postcss.org/) - To build the CSS
  - [cssnano](https://cssnano.co/)
  - [PostCSS Nested](https://github.com/postcss/postcss-nested)
  - [PostCSS Import](https://github.com/postcss/postcss-import)

## Install
You will need to have installed the [NodeJS](https://nodejs.org/en/) & the [Composer php](https://getcomposer.org/)
With these tools installed on the root directory of the plugin you will need to run the follow commands:

`npm install` or `yarn`

`composer update`

## Tasks
The plugin contain the following tasks on gulp
- `gulp blocks` - To build all JS & CSS of blocks
- `gulp admin` - To build all JS & CSS inside the folder `src/admin`
- `gulp public` - To build all JS & CSS inside the folder `src/public`
- `gulp` - Will run all tasks mentioned above

## WordPress/ACF Blocks
The plugin is ready to work with **ACF Block** and the native **WordPress/Gutenberg blocks**
The folder `blocks` has and example of how an ACF Block will work.
Inspired by the native blocks of WordPress the plugin also uses the file `block.json` to define some blocks attributes.
Blocks on the plugin is module based, in other words, all files from the block will be in the same folder.
To load your block you will need to add your block namespace into the array on the file `loadBlocks.php`. The name space must follow the structure of `FolderName/ClassName`

## Contribution

Feel free to open any PR or open any requests
