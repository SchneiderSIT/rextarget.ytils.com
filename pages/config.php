<?php

$content = '';
$buttons = '';
$addon = rex_addon::get('ytils_rex_target');

if (rex_post('formsubmit', 'string') === '1') {

    $selfUrls = rex_post('ytilsRexTargetSelf');
    $topUrls = rex_post('ytilsRexTargetTop');
    $blankUrls = rex_post('ytilsRexTargetBlank');
    $parentUrls = rex_post('ytilsRexTargetParent');
    $allOthers = rex_post('ytilsRexTargetBehaviourOthers');

    $this->setConfig('ytilsRexTargetSelf', $selfUrls);
    $this->setConfig('ytilsRexTargetTop', $topUrls);
    $this->setConfig('ytilsRexTargetBlank', $blankUrls);
    $this->setConfig('ytilsRexTargetParent', $parentUrls);
    $this->setConfig('ytilsRexTargetBehaviourOthers', $allOthers);

    echo rex_view::success($this->i18n('config_saved'));
}

$content .= '<fieldset><legend>' . $this->i18n('ytils_rex_target_adjustments') . '</legend><p style="margin-top: -15px; margin-bottom: 20px;">'.$this->i18n('ytils_rex_target_adjustments2').'</p>';

$formElements = [];
$n = [];
$n['label'] = '<label for="ytilsRexTargetSelf">' . $this->i18n('ytils_rex_target_self_prefixes') . '</label>';
$n['field'] = '<textarea style="min-height: 160px !Important; max-height: 160px; height: 160px;" class="form-control" id="ytilsRexTargetSelf" name="ytilsRexTargetSelf">'.$this->getConfig('ytilsRexTargetSelf').'</textarea>';
$formElements[] = $n;
$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php'); 

$formElements = [];
$n = [];
$n['label'] = '<label for="ytilsRexTargetTop">' . $this->i18n('ytils_rex_target_top_prefixes') . '</label>';
$n['field'] = '<textarea style="min-height: 160px !Important; max-height: 160px; height: 160px;" class="form-control" id="ytilsRexTargetTop" name="ytilsRexTargetTop">'.$this->getConfig('ytilsRexTargetTop').'</textarea>';
$formElements[] = $n;
$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="ytilsRexTargetBlank">' . $this->i18n('ytils_rex_target_blank_prefixes') . '</label>';
$n['field'] = '<textarea style="min-height: 160px !Important; max-height: 160px; height: 160px;" class="form-control" id="ytilsRexTargetBlank" name="ytilsRexTargetBlank">'.$this->getConfig('ytilsRexTargetBlank').'</textarea>';
$formElements[] = $n;
$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="ytilsRexTargetParent">' . $this->i18n('ytils_rex_target_parent_prefixes') . '</label>';
$n['field'] = '<textarea style="min-height: 160px !Important; max-height: 160px; height: 160px;" class="form-control" id="ytilsRexTargetParent" name="ytilsRexTargetParent">'.$this->getConfig('ytilsRexTargetParent').'</textarea>';
$formElements[] = $n;
$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="ytils_rex_target_others">' . $this->i18n('ytils_rex_target_others') . '</label>';
$select = new rex_select();
$select->setId('ytils_rex_target_others');
$select->setAttribute('class', 'form-control');
$select->setName('ytilsRexTargetBehaviourOthers');
$select->addOption($this->i18n('ytils_rex_target_others_nothing'), '');
$select->addOption('_self', '_self');
$select->addOption('_top', '_top');
$select->addOption('_blank', '_blank');
$select->addOption('_parent', '_parent');
$select->setSelected($this->getConfig('ytilsRexTargetBehaviourOthers'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$content .= "</fieldset>";

$formElements = [];
$n = [];
$n['field'] = '<button class="btn btn-save rex-form-aligned" type="submit" name="save" value="' . $this->i18n('config_save') . '">' . $this->i18n('config_save') . '</button>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$buttons = $fragment->parse('core/form/submit.php');
$buttons = '
<fieldset class="rex-form-action">
    ' . $buttons . '
</fieldset>
';

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit');
$fragment->setVar('title', $this->i18n('config'));
$fragment->setVar('body', $content, false);
$fragment->setVar('buttons', $buttons, false);
$output = $fragment->parse('core/page/section.php');

$output = '<form action="' . rex_url::currentBackendPage() . '" method="post"><input type="hidden" name="formsubmit" value="1" />' . $output . '</form>';

echo $output;
