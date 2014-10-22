<?php $uri = explode('?', $sf_request->getUri())[0]; ?>
<div class="container uni-style-block" id="headerSection">
	<div id="metaNavigation">
		<ul class="list-inline" id="languageSwitch">
			<li>
				<a href="http://dch.uni-koeln.de">Data Center for the Humanities</a>
			</li>
			<li>|</li>
			<li>
				<a href="<?php echo $uri . '?sf_culture=en'; ?>">EN</a>
			</li>
			<li>
				<a href="<?php echo $uri . '?sf_culture=de'; ?>">DE</a>
			</li>
		</ul>
	</div>
	<div id="mainLogo">
		<a href="http://www.uni-koeln.de">
			<?php echo image_tag('/images/UzK_Logo.png', 'alt="Universität zu Köln"') ?>
			<span class="hidden-text">Universität zu Köln</span>
		</a>
	</div>
	<div id="mainHeading">
		<div class="sub-header heading">Universität zu Köln &bull; <a href="http://www.thomasinstitut.uni-koeln.de/">Thomas-Institut</a></div>
		<h1 class="main-header heading"><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">Meister-Eckhart-Archiv</a></h1>
	</div>
</div>
