=== PMPro Reason for Cancelling ===
Contributors: strangerstudios, pbrocks, dlparker1005
Tags: pmpro, membership, reason, cancel
Requires at least: 3.5
Tested up to: 6.4
Stable tag: 1.1

Require members to provide a reason for leaving before they can cancel their membership.
This reason will be added to the emails sent to both the user and administrator.

== Description ==

Features:
* Require members to provide a reason for leaving before they can cancel their membership.

Simply activate the plugin and a new checkout page template will be used, requiring your users to enter a reason, before they can cancel their membership.
The reason will be added to the emails sent to both the user and administrator.

== Installation ==

1. Upload the `pmpro-reason-for-cancelling` directory to the `/wp-content/plugins/` directory of your site.
1. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= I found a bug in the plugin. =

Please post it in the issues section of GitHub and we'll fix it as soon as we can. Thanks for helping. https://github.com/strangerstudios/pmpro-reason-for-cancelling/issues

== Changelog ==
= 1.1 - 2024-07-15 =
* ENHANCEMENT: Added support for v3.1+ Paid Memberships Pro frontend changes.
* BUG FIX: Fixed conflict with the Unlock Protocol Add On where the Edit Member panel for this Add On may not show. #30 (dparker1005)

= 1.0 - 2024-02-21 =
* FEATURE: Added an Edit Member panel to view all of a user's cancellation reasons when using PMPro v3.0+. #29 (@dparker1005)
* ENHANCEMENT: Cancellation reasons are now stored in user meta instead of order notes when using PMPro v3.0+ to simplify querying cancellation reasons. #29 (@dparker1005)
* ENHANCEMENT: Adding a label to improve accessibility for the "reason for cancelling" field. #28 (@patric-boehner)
* BUG FIX: Adding missing `</form>` tag to the cancel page template. #24 (@dparker1005)
* REFACTOR: When using PMPro v3.0+, the plugin now uses built-in hooks to add the "reason for cancelling" field instead of a custom template. #29 (@dparker1005)

= 0.2.1 - 2021-09-13 =
* BUG FIX/ENHANCEMENT: Now ensuring that `levelstocancel` URL parameter is set when cancelling a level.

= 0.2 - 2020-09-03 =
* ENHANCEMENT: Added MMPU compatibility.
* ENHANCEMENT: Enabled translation/internationalization.
* BUG FIX/ENHANCEMENT: Now properly stripping slashes from reason for cancelling input.
* BUG FIX/ENHANCEMENT: Wrapped additional strings for localization (Thanks, Mirco Babini).
* BUG FIX: Resolved issue where blank order may be created during membership cancellation.

= .1.3 - 2020-01-14 =
* BUG FIX: Fixed issue where users would not be prompted for the reason for cancelling

= .1.2 =
* Prepared for translation

= .1.1 =
* Added readme.txt

= .1 =
* Initial version of the plugin.