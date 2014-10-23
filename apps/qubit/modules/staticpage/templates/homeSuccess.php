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

<?php /* The entire carousel implemented here completely adheres to Bootstrap 2.3.2 (which is used by this installation of AtoM by default. (see /vendor)).
         The code looks up, what files other than txt-files reside in the folder images/slideshow. */ ?>
<?php
  function trim_value(&$value)
  {
    $value = trim($value);
  }

  // The code looks up, which non-txt-files reside in the folder images/slideshow.
  // glob returns an array of filenames in the form of the string. (See error_log-function.)
  $dir = "images/slideshow/*[^.txt]";
  $images = glob($dir);
  //error_log("image files: " . print_r($images, true), 3, "/home/vagrant/atom-2/BernhardError.log");
  // Independently from how the files are sorted in the directory, they are sorted again here.
  sort($images);
  //error_log("image files sorted: " . print_r($images, true), 3, "/home/vagrant/atom-2/BernhardError.log");
  // Label headings are specified in the textfile label_headings.txt. The headings for the different carousel-slides are delimited by new lines.
  // Label headings are extracted from the file correctly, even if a lot of whitespace is sourrounding them.
  $textfile = "images/slideshow/label_headings.txt";
  $contents = file_get_contents($textfile);
  $label_headings = explode("\n", $contents);
  array_walk($label_headings, 'trim_value');
  $label_headings = array_filter($label_headings, 'strlen' );
  $label_headings = array_values($label_headings);
  //error_log("headings: " . print_r($label_headings, true), 3, "/home/vagrant/atom-2/BernhardError.log");
  // Same as above, only with label texts this time.
  $textfile = "images/slideshow/label_texts.txt";
  $contents = file_get_contents($textfile);
  $label_texts = explode("\n", $contents);
  array_walk($label_texts, 'trim_value');
  $label_texts = array_filter( $label_texts, 'strlen' );
  $label_texts = array_values($label_texts);
  //error_log("texts: " . print_r($label_texts, true), 3, "/home/vagrant/atom-2/BernhardError.log");
?>

<div id="myCarousel" class="carousel slide">
  <ol class="carousel-indicators">
    <?php for($i=0; $i < sizeof($images); $i++) { ?>
      <li data-target="#myCarousel" data-slide-to="<?php echo $i ?>" <?php if($i==0) echo "class=\"active\"" ?>></li>
    <?php } ?>
  </ol>

  <!-- Carousel items -->
  <div class="carousel-inner">
    <?php for($i=0; $i < sizeof($images); $i++) { ?>
         <?php
             $image_path = str_replace('images/', '', $images[$i]);
             $alt = $label_headings[$i];
         ?>

        <div class="<?php if($i==0) echo ("active "); ?>item">
	  <?php echo image_tag($image_path, array('alt' => $alt)); ?>
          <div class="carousel-caption">
           <h2><?php echo $label_headings[$i]; ?></h>
           <p><?php echo $label_texts[$i]; ?></p>
          </div>
        </div>
    <?php } ?>
  </div>

  <!-- Carousel nav -->
  <a class="carousel-control left" href="#myCarousel" data-slide="prev" style="top: 45%;">&lsaquo;</a>
  <a class="carousel-control right" href="#myCarousel" data-slide="next" style="top: 45%;">&rsaquo;</a>
</div>
<?php /* end of carousel */ ?>


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
