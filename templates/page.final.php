<?php
/**
 * @var array $_
 * @var \OCP\IL10N $l
 * @var \OCP\Defaults $theme
 */
?>

<div class="page content-final" data-title="<?php p($l->t('Get help')); ?>" data-subtitle="">
	<div class="description">
		<div class="description-block">
			<h3 class="icon-info"><?php p($l->t('Get more information')); ?></h3>
			<p><?php p($l->t('The Nextcloud documentation for home users:')); ?></p>
			<ul>
				<li><a href="<?php p(link_to_docs('user-')) ?>" target="_blank" rel="noreferrer noopener"><?php p($l->t('User manual')); ?></a></li>
				<li><a href="<?php p(link_to_docs('admin-')) ?>" target="_blank" rel="noreferrer noopener"><?php p($l->t('Admin manual')); ?></a></li>
				<li><a href="<?php p(link_to_docs('developer-')) ?>" target="_blank" rel="noreferrer noopener"><?php p($l->t('Developer manual')); ?></a></li>
			</ul>
			<p><?php p($l->t('You can also ask for help in our community support channels:')); ?></p>
			<ul>
				<li><a href="https://help.nextcloud.com" target="_blank" rel="noreferrer noopener"><?php p($l->t('the Nextcloud forums')); ?></a></li>
				<li><a href="https://riot.im/app/#/room/#freenode_#nextcloud:matrix.org" target="_blank" rel="noreferrer noopener"><?php p($l->t('the Nextcloud IRC chat channel on freenode.net')); ?></a></li>
			</ul>
		</div>
	</div>
	<div class="description">
		<div class="description-block">
			<h3 class="icon-user"><?php p($l->t('Start contributing')); ?></h3>
			<p><?php p($l->t('Do you want to get a certain improvement in Nextcloud? Did you find a problem? Do you want to help translate, promote or document Nextcloud?')); ?></p>
			<a href="https://nextcloud.com/contribute/" class="button" target="_blank" rel="noreferrer noopener"><?php p($l->t('Become part of the Community')); ?></a>
		</div>
		<div class="description-block">
			<h3 class="icon-link"><?php p($l->t('Enterprise support')); ?></h3>
			<p><?php p($l->t('If you run Nextcloud in a mission critical environment with large numbers of users and big amounts of data and need the certainty of support from the experts behind the Nextcloud technology, an Enterprise Subscription from Nextcloud is available with email and phone support.')); ?></p>
			<a href="https://nextcloud.com/enterprise/buy" class="button"target="_blank" rel="noreferrer noopener" ><?php p($l->t('Get enterprise support')); ?></a>
		</div>
	</div>
</div>
