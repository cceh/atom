<?php

/*
 * This file is part of the Access to Memory (AtoM) software.
 *
 * Access to Memory (AtoM) is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Access to Memory (AtoM) is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Access to Memory (AtoM).  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Build main user navigation menu as simple xhtml lists, relying on css styling to
 * format the display of the menus.
 *
 * @package    AccesstoMemory
 * @subpackage menu
 * @author     David Juhasz <david@artefactual.com>
 */
class MenuMainMenuComponent extends sfComponent
{
  public function execute($request)
  {
    if (!$this->context->user->isAuthenticated())
    {
      return sfView::NONE;
    }

    /*
    // Get menu objects
    $this->mainMenu = QubitMenu::getById(QubitMenu::MAIN_MENU_ID);

    if (!$this->mainMenu instanceof QubitMenu)
    {
      return sfView::NONE;
    }
    */

    $this->addMenu = QubitMenu::getById(QubitMenu::ADD_EDIT_ID);
    $this->manageMenu = QubitMenu::getById(QubitMenu::MANAGE_ID);
    $this->importMenu = QubitMenu::getById(QubitMenu::IMPORT_ID);
    $this->adminMenu = QubitMenu::getById(QubitMenu::ADMIN_ID);
//Bernhard
    $this->testMenu = QubitMenu::getById(QubitMenu::TEST_MENU_ID);
  }
}
