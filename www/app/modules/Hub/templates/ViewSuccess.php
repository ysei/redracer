<div>
	<small class="subheader">
		Updated <?= OurDate::prettyDate($resource['updated_at']) ?>.
<?php		if ($resource['license_text'] && $resource['license_url']): ?>
		<a href="<?= $resource['license_url'] ?>" class="license"><?= $resource['license_text'] ?></a> .
<?php		else: ?>
		Unclassified License .
<?php		endif; ?>
<?php		if (count($resource['tags']) ): ?>
		Tagged as
<?php			foreach ($resource['tags'] as $tag): ?>
			<a href="<?= $tag['url'] ?>"><?= $tag['word_clear'] ?></a>
<?php			endforeach; ?>.
<?php		endif; ?>
<?php		if ($resource['core_min'] && $resource['core_max']): ?>
		<a href="http://mootools.net/download/">MooTools <?= $resource['core_min'] ?> - <?= $resource['core_max'] ?></a>
<?php		elseif ($resource['core_min']): ?>
		<a href="http://mootools.net/download/">MooTools <?= $resource['core_min'] ?> +</a>
<?php		endif; ?>
	</small>

	<h3>
		<a href="<?= $resource['url'] ?>" class="bookmark"><?= $resource['title'] ?></a>
	</h3>
</div>

<?= $resource['text_html'] ?>

<p class="footer">
	<a href="<?= $resource['url_edit'] ?>">Edit</a>
</p>

<hr />

<div class="block span-7 colborder">
	<h3 class="green">Read More</h3>

<?php	if (count($resource['links']) ): ?>
	<dl class="links">
<?php		foreach ($resource['links'] as $link): ?>
		<dt>
			<em><?= $link['parsed']['host'] ?></em>
			<a href="<?= $link['url'] ?>"><?= $link['title'] ?></a>
			<small><a href="<?= $link['url_edit'] ?>" class="right">Edit</a></small>
		</dt>
<?php			if ($link['text']): ?>
		<dd>
			<p><?= $link['text'] ?></p>
		</dd>
<?php			endif; ?>
<?php		endforeach; ?>
	</dl>
<?php	else: ?>
	<p class="empty">
		No Links added yet!
	</p>
<?php	endif; ?>

	<p class="footer">
		<a href="<?= $resource['url_link'] ?>">Add a Link</a>
	</p>
</div>

<div class="span-10 last">
	<h3 class="red">Meet the Contributors</h3>

<?php	if (!$resource['claimed']): ?>
	<p>
		This Resource was not submitted by a contributor, it needs to be claimed.
		If you are one of the contributors, <a href="<?= $resource['url_claim'] ?>">claim it</a> now!
	</p>
	<p>
		<em>Unregistered Author</em>: <?= $resource['author'] ?>
	</p>
<?php	endif; ?>

<?php	if (count($resource['contributors']) ): ?>
	<dl class="devs">
<?php		foreach ($resource['contributors'] as $contributor): ?>
		<dt>
<?php			if ($contributor['title']): ?>
			<em title="Job Title"><?= $contributor['title'] ?>.</em>
<?php			endif; ?>
			<img src="<?= $contributor['user']['url_avatar'] ?>" />
			<a href="<?= $contributor['user']['url'] ?>" title="View Profile"><?= $contributor['user']['fullname'] ?></a>
			<em>(<?= $contributor['user']['nickname'] ?>)</em>
			<small><a href="<?= $contributor['url_edit'] ?>" class="right">Edit</a></small>
		</dt>
		<dd>

<?php			if ($contributor['text']): ?>
			<p>
				<?= $contributor['text'] ?>
			</p>
<?php			endif; ?>
		</dd>
<?php		endforeach; ?>
<?php	else: ?>
	<p class="empty">
		No Contributor registered yet!
	</p>
<?php	endif; ?>
	<p class="footer">
		<a href="<?= $resource['url_contributor'] ?>">Add me as Contributor</a>
	</p>
</div>
<hr class="clear" />

<?php	if ($resource['type'] == 0): ?>

<h3 class="purple">Releases</h3>

<?php		if (count($resource['releases']) ): ?>
<?php			foreach ($resource['releases'] as $release): ?>
	<ul>
		<h2>
			<a href="<?= $release['url'] ?>"><?= $release['version'] ?></a>
		</h2>
		<a href="<?= $release['url_edit'] ?>" class="right">Edit</a>

<?php				if ($release['text']): ?>
		<p>
			<?= $release['text'] ?>
		</p>
<?php				endif; ?>
	</div>
<?php			endforeach; ?>
<?php		else: ?>
	<p class="empty">
		No Releases yet!
	</p>
<?php		endif; ?>
	<p class="footer">
		<a href="<?= $resource['url_releases'] ?>">Add Release</a>
	</p>
<?php	endif; ?>