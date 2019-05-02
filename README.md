# angular-auto-modules
generates a module for each component recursively given a base directory.

**NOTE:** If your component .ts file is named something other than your component's identifier, you will need to manually fix the modules to match. 

E.g. if you have a component named `profile.component.ts` but you named it something like `MyCompanyProfileComponent`, then you will need to open the module and change the references from the auto-generated  `ProfileComponent` to match your `MyCompanyProfileComponent` reference instead.
