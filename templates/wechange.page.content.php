<?php print_unescaped(\OC::$server->getConfig()->getSystemValue('wechange_firstrun_main_text', '(wechange_firstrun_main_text)')); ?>

<p>
    <a href="<?php print_unescaped(\OC::$server->getConfig()->getSystemValue('wechange_firstrun_learn_more_url', 'wechange_firstrun_learn_more_url')); ?>" target="_blank" rel="noreferrer noopener">
        <?php print_unescaped(\OC::$server->getConfig()->getSystemValue('wechange_firstrun_learn_more_label', 'Mehr erfahren')); ?>
    </a>
</p>
<br/>

<div class="wizard-warning" <?php if (\OC::$server->getConfig()->getSystemValue('wechange_firstrun_warning_enabled', false) == false) {print_unescaped('style="display: none"');} ?>>
    <h2><?php print_unescaped(\OC::$server->getConfig()->getSystemValue('wechange_firstrun_warning_header', 'Achtung!')); ?></h2>
    <p>
        <?php print_unescaped(\OC::$server->getConfig()->getSystemValue('wechange_firstrun_warning_text', 'wechange_firstrun_warning_text')); ?>
    </p>
</div>



<?php
/*
<ul id="wizard-values">
    <li>
        <span class="icon-link"></span>
        <h3><?php p($l->t('Host your data and files where you decide')); ?></h3>
    </li>
    <li>
        <span class="icon-shared"></span>
        <h3><?php p($l->t('Open Standards and Interoperability')); ?></h3>
    </li>
    <li>
        <span class="icon-user"></span>
        <h3><?php p($l->t('100%% Open Source & community-focused')); ?></h3>
    </li>
</ul>
*/
?>