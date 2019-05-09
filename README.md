# angular-auto-modules
generates a module for each component recursively given a base directory. No, you don't need, and probably shouldn't have a module for every component, but when you need a lot of them, this is just way easier than using CLI.


## Usage

1. Place the `index.php` file inside of your project's `/src/app` folder
2. Open in `index.php` in your editor and change the `$base_directory` variable to fit your needs
3. Open up a terminal/console window
4. Navigate to the location of `index.php`
5. Run command `php -S localhost:8008`
6. Navigate to `localhost:8008` in your browser
7. Press the button
8. Review output for any errors


**NOTE:** If your component .ts file is named something other than your component's identifier, you will need to manually fix the modules to match. 

E.g. if you have a component named `profile.component.ts` but you named it something like `MyCompanyProfileComponent`, then you will need to open the module and change the references from the auto-generated  `ProfileComponent` to match your `MyCompanyProfileComponent` reference instead.
