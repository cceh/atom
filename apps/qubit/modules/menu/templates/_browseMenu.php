<div id="browse-menu">

  <a class="top-item top-dropdown" data-toggle="dropdown" data-target="#"> <div class="icon-arrow-down"></div>  <?php echo $browseMenu->getLabel(array('cultureFallback' => true)) ?></a>

  <div class="top-dropdown-container">

    <div class="top-dropdown-arrow">
      <div class="arrow"></div>
    </div> 

    <div class="top-dropdown-header">
      <?php echo $browseMenu->getLabel(array('cultureFallback' => true)) ?>
    </div>

    <div class="top-dropdown-body">
      <ul>
        <?php echo QubitMenu::displayHierarchyAsList($browseMenu, 0) ?>
      </ul>
    </div>

    <div class="top-dropdown-bottom"></div>

  </div>

</div>
