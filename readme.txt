=== Link To Bible ===
Contributors: erfonlinedev
Donate link: https://www.bibleserver.com/donate
Tags: bible, bible verse, bible reference, bibleserver.com, bibel
Requires at least: 5.2
Tested up to: 6.6.1
Stable tag: 3.0.3
Requires PHP: 5.6
License: GPLv3 or later
License URI: https://www.gnu.org/copyleft/gpl.html

Links bible-references in posts automatically to the appropriate bible-verse(s) at bibleserver.com.

== Description ==

Link To Bible links any bible reference (e.g. "Genesis 20:1" (en) or "Lukas 5,3" (de)) you write in a post automatically to the appropriate bible verse(s) at bibleserver.com.

You can hereby choose from many different bible versions in different languages. (See https://www.bibleserver.com/webmasters for all availabe languages and bible versions.)

Bibleserver.com detects language specific the most common notations of bible references.

= Notes =
- This plugin uses the webservice of bibleserver.com
- <b>The links to bibleserver.com are added while saving a post</b>, because the requests to bibleserver.com are limited per day and site. For posts created before activating 'Link-To-Bible' and never saved since then, the links to bibleserver.com are added when the post is viewed the first time.
- Changing an already linked bible reference (e.g. "Gen 1,2" -> "Gen 2,1"), saving the post will automatically update the link to bibleserver.com.

= Privacy =
The following information is transmitted to bibleserver.com to add the links:<ul>
<li>Your API-Key</li>
<li>The URL of your blog</li>
<li>The selected bible version</li>
<li>The text of your post including all markups (and may be content or markup added by other plugins or themes)</li>
<li>The version of this plugin, the version of your wordpress installation and the php version running your wordpress installation</li>
</ul>

For more information see the privacy statement of bibleserver.com: https://www.bibleserver.com/webmasters/#privacy

= License =
- This plugin is licensed under the GPLv3. (http://www.gnu.org/licenses/gpl.html). You can use it free of charge on your personal or commercial blog.
- It is published with the explicit permission of bibleserver.com (ERF Medien e.V.)

= Translation =
Although the bible versions at bibleserver.com are available in many different languages, 'Link To Bible' itself is just available in English and German. If you would like to contribute a translation for another language, please contact <info@bibleserver.com> .

== Installation ==
1. Search for link-to-bible in your WordPress backend and click install, or download the link-to-bible.zip file and unzip it.
2. If you have downloaded the zip, move the 'link-to-bible' folder into [WORDPRESS]/wp-content/plugins folder
3. Activate the plugin in your WordPress Admin area.
4. Select "Settings" to choose a bible version.

== Frequently Asked Questions ==

= How can I disable the linking of a bible-reference? =
You can mark any text with the css-class 'nolink' to avoid linking it to bibleserver.com; e.g. <code><span class="nolink">Mt 2,10 or Gen 5,11 will not be linked to bibleserver.com</span></code>.
To disable the linking of a whole post, just add the metadata 'LTB_DISABLE' to the post. (Adding 'LTB_DISABLE' to an existing post with existing links to bibleserver.com will not remove these existing links.)

= Can I set the bible version per post? =
Yes. You can set the bible version by adding a custom field to the post with 'LTB_BIBLEVERSION' as the key and the bible version code from bibleserver.com (https://www.bibleserver.com/webmasters/) as the value. E.g. set the custom field LTB_BIBLEVERSION=KJV to use the 'King James Version' for this post.

= I have a question / The plugin does not work for me / I have a feature request ... =
If you have any issues with the plugin, please write to info@bibleserver.com

== Known bugs ==

- With Wordpress 5+ errors / warnings announced by bibleserver.com are not shown in admin panel.
  (https://wordpress.stackexchange.com/questions/377492/admin-notices-are-not-shown-in-save-post-hook-with-wp5)

== Changelog ==

= 3.0.0 =

- bible versions updated
- complete refactor of the plugin

= 2.5.10 =

- Security fix: Prevent possible XSS attack by escaping the API key in the admin panel

= 2.5.9 =

- Improved handling of http error codes receiving from bibleserver.com backend

= 2.5.8 =

- Fixed problem with Yoast SEO on uploading media
  (Thanks to Timotheus I., providing the patch.)

= 2.5.7 =

- Updated to new wordpress version
- Updated list of bible versions from bibleserver.com

= 2.5.6 =

- Changed to new bibleversion.com api (to get api key)

= 2.5.5 =

- Added a workaround to ommit error 'Link-To-Bible Error: "ERROR - unknown data"' on creating new posts
- Updated all bibleserver.com urls to use https ones (with disabled host verification)

= 2.5.4 =

- Updated biblelist from bibleserver.com

= 2.5.3 =

- Fixed bug regarding setting of default bible version

= 2.5.2 =

- Fixed bug regarding user agent composition
- Fixed bug regarding obsolete request of api-key on validating options

= 2.5.1 =

- Fixed bug regarding surplus connections to bibleserver.com
- Set a default bible version, if none set for some reasons (in database)
- Update the plugin version in database, if outdated.

= 2.5.0 =

- Updated biblelist from bibleserver.com ('LUT' is now 'Lutherbibel 2017', added 'LUT84' for 'Lutherbibel 1984')
- Improved check of posts, if they needed to be parse by bibleserver.com (e.g. in cause of some changes)
- Changed HTTP-UserAgent to include wordpress-version and php-version

= 2.4.2 =

- Added better handling of network errors

= 2.4.1 =

- Fixed bug regarding bible version selection with active debug mode

= 2.4.0 =

- Updated biblelist from bibleserver.com (removed 'BLG', added 'BGV')
- Better handling of unavailibility of bibleserver.com (only curl-binding)
- Changed HTTP-UserAgent to be more convenient
- Fixed a bug regarding changing the special bible version for a special post
- Elimated many php warnings (Thanks to Peter Grab!)

= 2.3.2 =

- Fixed bug regarding http-post-request without php5-curl.

= 2.3.1 =

- Fixed bug regarding compatibility to PHP 5.3 (The plugin is now tested with PHP 5.2, 5.3, 5.4, 5.5 and 5.6)

= 2.3.0 =

- Link To Bible can now automatically retrieve the API-Key of bibleserver.com (default for new installations)
- Removed dependency to php5-curl (it is still used, if available)
- Updated biblelist from bibleserver.com
- Some minor bugfixes

= 2.2.1 =

- Fixed translation

= 2.2.0 =

- Link To Bible can be disabled for a single post using metadata 'LTB_DISABLE'
- Language for parsing bible references can be set to post's bible version or system locale (default)
- Performance optimizations

= 2.1.1 =

- Fixed typos, translation and html problems.

= 2.1.0 =

- The language of the available bible versions can be set in the settings now.
- The bible version per post can be set using post's metadata ('LTB_BIBLEVERSION') now.
- Link-To-Bible now checks for the availability of needed curl-php5-library
- Revised error-handling, some refactorings
- Some minor bugfixes, changes
- Improved documentation
- Updated biblelist from bibleserver.com

= 2.0.1 =

- Link-To-Bible now adds the links to bibleserver.com also to old posts, when they are viewed the first time.
- Link-To-Bible now changes the links, if the selected bible version is changed. (The links are changed the first time the post is viewed or saved.)

= 1.1.3 =

- Bugfix regarding issue "unexpected end of file'"
- Some minor bugfixes, changes

= 1.1.2 =

- Update bible list
- Some refactoring

= 1.1.1 =

- Some minor bugfixes
- A new major version will be released in the next months.

= 1.1.0 =

- Add the option to ignore false-positive-linkings
- Fix some minor bugs
- Added and translated some error-messages

= 1.0.4 =

- Fix regarding issue with "Cannot modify header information"

= 1.0.2 =

- Fix of some minor bugs

= 1.0.0 =

- Initial version
