=== PMPro Reason for Cancelling ===
Contributors: strangerstudios, pbrocks, dlparker1005
Tags: pmpro, membership, reason, cancel
Requires at least: 3.5
Tested up to: 5.5
Stable tag: 0.2

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