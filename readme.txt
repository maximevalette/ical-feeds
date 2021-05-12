=== iCal Feeds ===
Contributors: maximevalette, geekysoft, contemplate
Donate link: http://maxime.sh/paypal
Tags: uri.lv, ical, posts, feed, future, calendar, agenda, webcal
Requires at least: 3.0
Tested up to: 4.7.2
Stable tag: 1.5.3

Generate a customizable iCal feed of your present and future blog posts.

== Description ==

With the iCal Feeds WordPress plugin you can have an iCal feed to have your blog posts
(past and future with a customizable secret parameter) in your favorite iCal software: Google Calendar,
Outlook, Hotmail, iCal, Evolution…

== Installation ==

1. Copy the ical-feeds folder into wp-content/plugins
2. Activate the plugin through the Plugins menu
3. Configure your feed from the new iCal Feeds Settings submenu

== Changelog ==

= 1.5.3 =

* NEW: ability for custom field event link

= 1.5.2 =

* NEW: filter feed by single post ids
* NEW: replace default blogname ( Thanks Poul Hornsleth )
* NEW: replace default ics file name ( Thanks Poul Hornsleth )
* NEW: add an event description from excerpt or custom field
* NEW: add post link to the description
* NEW: add alarm ability with custom interval ( may be ignored in popular Calendar apps )

= 1.5.1 =

* NEW: Default Start Time per post setting
* ADDED: ORGANIZER field to iCal file for better validation
* FIX: encoded UID field in iCal file for better validation

= 1.5 =

* New number of Future Posts setting
* Replaced get_results with Wp_Query
* Better implementation of the custom date field to filter results returned
* Timezone support for the custom date field
* Reorganized code & Added comments

Thanks to @contemplate (http://contemplatedesign.com) for this new version!

= 1.4.2 =

* Fixing validation errors, thanks to @contemplate (http://contemplatedesign.com).
* Added custom field for end date support, thanks to @contemplate (http://contemplatedesign.com).

= 1.4.1 =

* Added custom field for date support, thanks to @contemplate (http://contemplatedesign.com).

= 1.4 =

* Added configuration option for post limit, thanks to Daniel Aleksandersen (https://ctrl.blog).
* Added link tag in wp_Head to iCalendar feed, thanks to Daniel Aleksandersen (https://ctrl.blog).
* Set limit to 50 posts by default to limit bandwidth usage, thanks to Daniel Aleksandersen (https://ctrl.blog).
* Fixed RFC implementation errors and Outlook.com compatibility, thanks to Daniel Aleksandersen (https://ctrl.blog).

= 1.3 =
* Added custom post type support, thanks to user contemplate!

= 1.2.5 =
* Fixed a bug with UTC timezone, thanks to Daniel Aleksandersen (https://ctrl.blog).

= 1.2.4 =
* Fixed event delay setting.
* Fixed timezone issue.

= 1.2.3 =
* Improved SQL queries.

= 1.2.2 =
* Category feed fix.
* Multiple categories support.

= 1.2.1 =
* Slug fix.

= 1.2 =
* Better at handling timezones.

= 1.1 =
* You can now specify a time interval per blog post.

= 1.0 =
* First version. Enjoy!
