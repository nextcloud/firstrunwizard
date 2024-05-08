<!--
  - SPDX-FileCopyrightText: 2016-2024 Nextcloud GmbH and Nextcloud contributors
  - SPDX-FileCopyrightText: 2013-2016 ownCloud, Inc.
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
# 🔮 First run wizard

[![REUSE status](https://api.reuse.software/badge/github.com/nextcloud/firstrunwizard)](https://api.reuse.software/info/github.com/nextcloud/firstrunwizard)

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

### Add Nextcloud Hub release notes

1. Open the `src/hub-release.ts` file
2. Adjust the `version` property to reflect the new Hub release version
3. Adjust the `link` (e.g. blog post)
4. Add `releaseNotes`, this is an array of strings, for localization those are translated using `t('firstrunwizard', 'YOUR MESSAGE')`
5. Change the `videoAltText` for the Hub release animation if needed (alternative text for accessibility)
6. Adjust the `shareSubject` which is used when users share their thoughts about the release on social media
7. Replace `img/nextcloudHub.mp4` and `img/nextcloudHub.webm` (VP9) with updated animations
8. Update the current changelog version in `lib/Constants.php`
