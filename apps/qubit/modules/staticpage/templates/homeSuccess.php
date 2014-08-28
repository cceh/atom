<?php decorate_with('layout_2col') ?>

<?php slot('title') ?>
  <h1><?php echo render_title($resource->getTitle(array('cultureFallback' => true))) ?></h1>
<?php end_slot() ?>

<?php slot('sidebar') ?>

  <?php echo get_component('menu', 'staticPagesMenu') ?>

  <section>
    <h2><?php echo __('Browse by') ?></h2>
    <ul>
      <?php $browseMenu = QubitMenu::getById(QubitMenu::BROWSE_ID) ?>
      <?php if ($browseMenu->hasChildren()): ?>
        <?php foreach ($browseMenu->getChildren() as $item): ?>
          <li><a href="<?php echo url_for($item->getPath(array('getUrl' => true, 'resolveAlias' => true))) ?>"><?php echo esc_specialchars($item->getLabel(array('cultureFallback' => true))) ?></a></li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
  </section>

  <?php echo get_component('default', 'popular', array('limit' => 10, 'sf_cache_key' => $sf_user->getCulture())) ?>

<?php end_slot() ?>

<?php /* The entire carousel was added at a later stage, hardcoded here, completely adhering to Bootstrap 2.3.2 (which is used by this installation of AtoM by default. (see /vendor)).
         Images should be chosen dynamically/automated, so that it is easy to service by non-IT staff later. */ ?>
<div id="myCarousel" class="carousel slide">
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>
  <!-- Carousel items -->
  <div class="carousel-inner">
    <div class="active item">
      <img src="http://cceh.uni-koeln.de/themes/danland/images/slideshows/dixit.jpg" alt="Köln 1">
      <div class="carousel-caption">
        <h4>Erstes Bild Label</h4>
        <p>Dies ist ein Blindtext. Er füllt nur Platz aus und bedeutet nur sich selbst.</p>
      </div>
    </div>
    <div class="item">
      <img src="http://cceh.uni-koeln.de/themes/danland/images/slideshows/burger.jpg" alt="Köln 2">
      <div class="carousel-caption">
        <h4>Zweites Bild Label</h4>
        <p>Dies ist ein Blindtext. Er füllt nur Platz aus und bedeutet nur sich selbst.</p>
      </div>
    </div>
    <div class="item">
      <img src="http://cceh.uni-koeln.de/themes/danland/images/slideshows/arachne.jpg" alt="Köln 3">
      <div class="carousel-caption">
        <h4>Drittes Bild Label</h4>
        <p>Dies ist ein Blindtext. Er füllt nur Platz aus und bedeutet nur sich selbst.</p>
      </div>
    </div>

    <div class="item">
      <img src="http://cceh.uni-koeln.de/themes/danland/images/slideshows/genderforum.jpg" alt="Köln 4">
      <div class="carousel-caption">
        <h4>Viertes Bild Label</h4>
        <p>Dies ist ein Blindtext. Er füllt nur Platz aus und bedeutet nur sich selbst.</p>
      </div>
    </div>

  </div>
  <!-- Carousel nav -->
  <a class="carousel-control left" href="#myCarousel" data-slide="prev" style="top: 45%;"><div style="margin-top: 3px;">&lsaquo;</div></a>
  <a class="carousel-control right" href="#myCarousel" data-slide="next" style="top: 45%;"><div style="margin-top: 3px;">&rsaquo;</div></a>
</div>
<?php /*
<div class="page">
  <?php echo render_value($sf_data->getRaw('content')) ?>
</div>
*/ ?>


<?php if (QubitAcl::check($resource, 'update')): ?>
  <?php slot('after-content') ?>
    <section class="actions">
      <ul>
        <li><?php echo link_to(__('Edit'), array($resource, 'module' => 'staticpage', 'action' => 'edit'), array('title' => __('Edit this page'), 'class' => 'c-btn')) ?></li>
      </ul>
    </section>
  <?php end_slot() ?>
<?php endif; ?>

