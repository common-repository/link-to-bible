<?php

namespace LTB\View;

use LTB\Config;
use LTB\Content\BibleProvider;
use LTB\Dto\Action;
use LTB\HasActionsInterface;
use LTB\Options\Options;

class AdminPage implements HasActionsInterface {

	public static function loadJquery() {
		\wp_enqueue_script('jquery');
	}

	public static function renderOptionsPage() {
		Options::validateOptions();


		$options = Options::all();

		// Save manually entered api-key
		if ((!isset ($options [Options::OPTION_API_KEY_AUTOMATIC_RETRIEVAL]) || (!$options [Options::OPTION_API_KEY_AUTOMATIC_RETRIEVAL]))) {
			$options [Options::OPTION_API_KEY_MANUAL] = isset($options[Options::OPTION_API_KEY]) ? $options[Options::OPTION_API_KEY] : '';
			update_option('ltb_options', $options);
		}

		?>

        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                // Set bibleversions depending on selected language
                jQuery("#langsel").on('change keyup', function () {
                    var $langsel = $(this);
                    jQuery.getJSON('<?php print plugin_dir_url(__DIR__ . '/../../ltb.php') . "resources/bibleversions.json" ?>', function (data) {
                        var $key = $langsel.val();
                        var $vals = data[$key].bible_versions;
                        var $bversel = jQuery("#bversel");
                        var $curlang = "<?php print isset($options[Options::OPTION_BIBLE_ABBR]) ? $options[Options::OPTION_BIBLE_ABBR] : ""; ?>";
                        $bversel.empty();
                        jQuery.each($vals, function (key, value) {
                            $bversel.append("<option value='" + key + "'" + ($curlang == key ? "selected" : "") + ">" + value + "</option>");
                        });
                    });
                }).trigger('change');

                // Auto-Set of API-Key
                jQuery("#ltb_aak_cb").change(function () {
                    jQuery("#ltb_apikey_inp").prop("disabled", this.checked);
                    jQuery("#ltb_apikeynote").css("display", this.checked ? "none" : "");
                }).trigger('change');
            });
        </script>
        <div class="wrap">
            <h2><?php _e('Link To Bible Settings', 'ltb'); ?></h2>
            <form action="options.php" id="ltb_options_form" method="post">
				<?php settings_fields('ltb_plugin_options'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">Bibleserver.com API-Key</th>
                        <td>
                            <p>
                                <input type="checkbox" id="ltb_aak_cb" name="ltb_options[aak_on]"
                                       value="1"<?php checked(Options::isAutomaticRetrieval()); ?> />
								<?php _e("Retrieve API-Key automatically", "ltb") ?>
                            </p>
                            <p>
                                <input type="text" id="ltb_apikey_inp" size="60" name="ltb_options[apikey]"
                                       value="<?php echo htmlspecialchars(Options::getApiKey('')); ?>"/>
                            </p>
                            <p class="description" id="ltb_apikeynote">
								<?php printf(__('The API-Key can be get %shere%s. No registration is needed!<br>You need to use the address of your blog (%s) as the domainname.', 'ltb'), '<a href="http://www.bibleserver.com/webmasters/#apikey" target="_blank">', '</a>', Options::getSiteUrl()) ?>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><?php _e('Bible Version', 'ltb') ?></th>
                        <td>
                            <p>
                                <select id='langsel' name='ltb_options[biblelang]'>
									<?php foreach (BibleProvider::getBibles() as $key => $value) { ?>
                                        <option value='<?php echo $key ?>' <?php selected($key, $options['biblelang']); ?>><?php echo $value['name'] ?></option>
									<?php } ?>
                                </select>
                                &nbsp;&nbsp;&nbsp;
                                <select id='bversel' name='ltb_options[translation]'></select>
                            </p>
                            <p class="description">
								<?php _e('Attention: Some bible versions may not contain the text of the whole bible.', 'ltb') ?>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><?php _e('Other settings', 'ltb') ?></th>
                        <td>
                            <input type="checkbox" name="ltb_options[refformatlang]"
                                   value="1"<?php checked(Options::isReformatLang()); ?> />
							<?php _e("Use the language of a post's bible version for detecting bible references", "ltb") ?>
                            <p class="description">
								<?php printf(__("The format of bible references depends on the used language. (e.g. English &#8594; 'Gen 1:20', German &#8594; 'Mose 1,20')<br>Therefore you can use the language of wordpress [%s] for all posts, or the language of the bible version of the particular post.", 'ltb'), Config::getLocale()) ?>
                            </p>
                        </td>
                    </tr>
                </table>

                <p class="submit">
                    <input name="ltb_submit" type="submit" class="button-primary"
                           value="<?php _e('Submit Changes', 'ltb') ?>"/>
                </p>

            </form>
        </div>
		<?php
	}

	public static function addAdminPageToMenu() {
		\add_options_page(
			Config::get()->getPluginName(),
			'Link To Bible',
			'manage_options',
			'ltb_plugin',
			[
				AdminPage::class,
				'renderOptionsPage'
			]
		);
	}

	public static function getActions() {
		return [
			new Action('admin_menu', [AdminPage::class, 'addAdminPageToMenu']),
			new Action('wp_enqueue_script', [AdminPage::class, 'loadJquery']),
		];
	}
}
