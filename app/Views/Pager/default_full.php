<?php

/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(1);
?>

<div class="two_flex_column" style="margin-top:10px;margin-bottom:10px">
    <div>
	</div>

    <div>
		<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
			<ul class="pagination" style="margin:0px">

				<?php if ($pager->hasPrevious()) : ?>
					<li class="page-item">
						<a class="page-link" href="<?= $pager->getPrevious() ?>" tabindex="-1" aria-disabled="true">
							<?= lang('Pager.previous') ?>
						</a>
					</li>
				<?php endif ?>

				<?php foreach ($pager->links() as $link) : ?>
					<li <?php if($link['active']){ echo 'class="page-item active"';}else{ echo 'class="page-item"';} ?> >
						<a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
					</li>
				<?php endforeach ?>

				<?php if ($pager->hasNext()) : ?>
					<li class="page-item">
						<a class="page-link" href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
							<?= lang('Pager.next') ?>
						</a>
					</li>
				<?php endif ?>

			</ul>
		</nav>
	</div>
</div>




	

