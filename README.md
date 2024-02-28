# 🔮 First run wizard

A first run wizard that explains the usage of Nextcloud to new users

![](https://user-images.githubusercontent.com/3404133/51537050-bcc73e00-1e4d-11e9-8de0-29e6951c2b29.png)

## Configuration

No configuration is needed, but it is possible to prevent the wizard from opening for users by default.
When disabled users can only open it from manually clicking "About" in the user menu.

This can be done by setting an app setting value:

```
occ config:app:set --value false firstrunwizard wizard_enabled
```

## Development setup

Make sure you have `node`, `npm` and `make` installed on your system.

1. ☁ Clone the app into the `apps` folder of your Nextcloud: `git clone https://github.com/nextcloud/firstrunwizard.git`
2. 👩‍💻 Run `npm ci` to install the dependencies
3. 🏗 To build the Javascript after you have made changes, run `npm run build`
4. ✅ Enable the app through the app management of your Nextcloud
5. 🎉 Partytime! Help fix [some issues](https://github.com/nextcloud/firstrunwizard/issues) and [review pull requests](https://github.com/nextcloud/firstrunwizard/pulls) 👍
