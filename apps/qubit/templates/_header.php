<?php /*added by Bernhard*/ include '_uni_koeln_header.php' ?>
<?php /*added by Bernhard*/ include '_mea_menu.php' ?>

<?php echo get_component('default', 'updateCheck') ?>

<header id="top-bar" class="container">

<?php /* Bernhard says: We don't want the AtoM-Logo in the top-bar!
  <?php if (sfConfig::get('app_toggleLogo')): ?>
    <?php echo link_to(image_tag('logo'), '@homepage', array('id' => 'logo', 'rel' => 'home')) ?>
  <?php endif; ?>

  <?php if (sfConfig::get('app_toggleTitle')): ?>
    <h1 id="site-name">
      <?php echo link_to('<span>'.sfConfig::get('app_siteTitle').'</span>', '@homepage', array('rel' => 'home', 'title' => __('Home'))) ?>
    </h1>
  <?php endif; ?>
  */ ?>

  <nav class"navbar navbar-default">

    <?php echo get_component('menu', 'userMenu') ?>

    <?php echo get_component('menu', 'quickLinksMenu') ?>

    <?php echo get_component('menu', 'changeLanguageMenu') ?>

    <?php echo get_component('menu', 'mainMenu', array('sf_cache_key' => $sf_user->getCulture().$sf_user->getUserID())) ?>

  </nav>

  <div id="search-bar">

    <?php echo get_component('search', 'box') ?>

    <?php echo get_component('menu', 'browseMenu', array('sf_cache_key' => $sf_user->getCulture().$sf_user->getUserID())) ?>

  </div>

  </section>

  <?php echo get_component_slot('header') ?>

</header>

<?php /*
<?php if (sfConfig::get('app_toggleDescription')): ?>
  <div id="site-slogan">
    <div class="container">
      <div class="row">
        <div class="span12">
          <span><?php echo sfConfig::get('app_siteDescription') ?></span>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
*/ ?>