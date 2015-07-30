<div id="navContainer" class="container">

	<?php $mea_slug = rtrim(file_get_contents("mea.slug", FILE_USE_INCLUDE_PATH)); ?>
	<div id="secLogo">
		<a href="<?php echo $_SERVER['SCRIPT_NAME'] . "/" . $mea_slug; ?>"
			><?php echo image_tag('/images/MEA-Schriftzug-40.png', 'alt="MEA Logo"');
			?></a>
	</div>

	<?php
		function static_page_link($page, $title, $klass = 'menuItemLink') {
			$opts = array('class' => $klass);
			$url = $_SERVER['SCRIPT_NAME'] . '/' . $page;

			echo link_to($title, $url, $opts);
		}
	?>

	<nav id="siteNavigation">
		<ul class="list-inline" id="main-topics">
			<li class="main-item">
				<div class="main-item-inner">
					<?php static_page_link('ueber-meister-eckhart', 'Über Meister Eckhart', 'main-item-link'); ?>
					<ul class="sub-topics">
						<li>
							<?php static_page_link('sein-leben', 'Sein Leben'); ?>
						</li>
						<li>
							<?php static_page_link('seine-werke', 'Seine Werke'); ?>
						</li>
						<li>
							<?php static_page_link('chronologie', 'Chronologie'); ?>
						</li>
					</ul>
				</div>
			</li>
			<li class="main-item">
				<div class="main-item-inner">
					<?php static_page_link('ueber-das-mea', 'Über das MEA', 'main-item-link'); ?>
					<ul class="sub-topics">
						<li>
							<?php static_page_link('team-kontakt', 'Team/Kontakt'); ?>
						</li>
						<li>
							<?php static_page_link('geschichte', 'Geschichte'); ?>
						</li>
						<li>
							<?php static_page_link('bestandsuebersicht', 'Bestandsübersicht'); ?>
						</li>
						<li>
							<?php static_page_link('erschliessung', 'Wissenschaftliche Erschließung'); ?>
						</li>
					</ul>
				</div>
			</li>
			<li class="main-item">
				<div class="main-item-inner">
					<?php static_page_link('archivkatalog', 'Archivkatalog', 'main-item-link'); ?>
					<ul class="sub-topics">
						<li>
							<?php static_page_link('hilfe', 'Hilfe zur Benutzung'); ?>
						</li>
						<li>
							<?php static_page_link('gesamtkatalog', 'Gesamtkatalog'); ?>
						</li>
						<li>
							<?php static_page_link('digitale-medien', 'Digitale Medien'); ?>
						</li>
						<li>
							<?php static_page_link('verzeichnisse', 'Verzeichnisse'); ?>
						</li>
					</ul>
				</div>
			</li>
			<li class="main-item">
				<div class="main-item-inner">
					<?php static_page_link('bibliothek', 'Bibliothek', 'main-item-link'); ?>
					<ul class="sub-topics">
						<li>
							<?php static_page_link('literatur-zum-mea', 'Literatur zum Meister-Eckhart-Archiv'); ?>
						</li>
						<li>
							<?php static_page_link('meister-eckharts-werke', 'Meister Eckharts Werke'); ?>
						</li>
						<li>
							<?php static_page_link('sekundaerliteratur', 'Sekundärliteratur über Meister Eckhart'); ?>
						</li>
					</ul>
				</div>
			</li>
		</ul>
	</nav>
</div>
