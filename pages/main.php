<?php

$content = $this->i18n('ytils_rex_target_main_content');
$content = str_replace('{{documentationUrlEn}}', '<a href="https://www.ytils.com/en/rextarget" target="_blank">ytils.com/rextarget</a>', $content);

$fragment = new rex_fragment();
$fragment->setVar('title', $this->i18n('ytils_rex_target_main_title'), false);
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');
