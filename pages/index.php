<?php

echo rex_view::title($this->i18n('ytils_rex_target_title'));
$subpage = rex_be_controller::getCurrentPagePart(2);
rex_be_controller::includeCurrentPageSubPath();
