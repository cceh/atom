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
 * Information Object - editIsad
 *
 * @package    AccesstoMemory
 * @subpackage informationObject - initialize an editIsad template for updating an information object
 * @author     Peter Van Garderen <peter@artefactual.com>
 * @author     Jesús García Crespo <correo@sevein.com>
 */
class sfMeaPluginEditAction extends InformationObjectEditAction
{
  // Arrays not allowed in class constants
  public static
    $NAMES = array(
      'accessConditions',
      'accruals',
      'acquisition',
      'appraisal',
      'archivalHistory', //MEA Herkunft externer Akten
      'arrangement',
      'creators',
      'descriptionDetail',
      'descriptionIdentifier',
      'extentAndMedium',
      'findingAids',
      'identifier',
      'institutionResponsibleIdentifier',
      'language',
      'languageNotes',
      'languageOfDescription',
      'levelOfDescription',  //MEA Beschreibungsebene
      'locationOfCopies',
      'locationOfOriginals',
      'nameAccessPoints',
      'physicalCharacteristics',
      'placeAccessPoints',
      'relatedUnitsOfDescription',
      'repository',
      'reproductionConditions',
      'revisionHistory',
      'rules',
      'scopeAndContent',  //MEA Umfang und Inhalt
      'scriptOfDescription',
      'script',
      'sources',
      'subjectAccessPoints',
      'descriptionStatus',
      'publicationStatus',
      'displayStandard',
      'displayStandardUpdateDescendants',
      'title'      /*,
//Bernhard 11.06.2014
      'signatur_b',
      'titel_b',
      'datum_entstehungszeitraum_b',
      'datum_entstehungszeitraum_von_b',
      'datum_entstehungszeitraum_bis_b',
      'beschreibungsebene_b',                 // ist gleich dem alten levelOfDescription. Analoges Vorgehen angedacht
      'umfang_und_materialitaet_b',
      'name_der_institution_meister_b',
      'herkunft_externer_akten_b',            // equals AtoM archivalHistory.
      'letzter_eigentuemer_der_akten_b',
      'umfang_und_inhalt_b',                  // equalsscopeAndContent
      'zugangsbestimmungen_GlobalEintragen_b',
      'reproduktionsbestimmungen_GlobalEintragen_b',
      'sprache_des_schriftstuecks_b',
      'verwandte_verzeichnungseinheiten_b',
      'veroeffentlichungen_sekundaerliteratur_b',
      'oeffentliche_bemerkung_b',
      'bearbeitering_bearbeitungsdatum_KlarName_b',
      'verzeichnungsdatum_b',
      'interne_bemerkung_b',
      'publikationsstatus_entwurf_oder_veroeffentlicht_b',
      'ggf_weitere_projektspezifische_felder_wie_Ort_Absender_Empfaenger_Betreff_b'
*/ );

// /Bernhard 11.06.2014

  protected function earlyExecute()
  {
    parent::earlyExecute();

    $this->isad = new sfMeaPlugin($this->resource);

    $title = $this->context->i18n->__('Add new archival description');
    if (isset($this->getRoute()->resource))
    {
      if (1 > strlen($title = $this->resource->__toString()))
      {
        $title = $this->context->i18n->__('Untitled');
      }

      $title = $this->context->i18n->__('Edit %1%', array('%1%' => $title));
    }

    $this->response->setTitle("$title - {$this->response->getTitle()}");

    $this->eventComponent = new sfMeaPluginEventComponent($this->context, 'sfMeaPlugin', 'event');
    $this->eventComponent->resource = $this->resource;
    $this->eventComponent->execute($this->request);

    $this->rightEditComponent = new RightEditComponent($this->context, 'right', 'edit');
    $this->rightEditComponent->resource = $this->resource;
    $this->rightEditComponent->execute($this->request);

    $this->publicationNotesComponent = new InformationObjectNotesComponent($this->context, 'informationobject', 'notes');
    $this->publicationNotesComponent->resource = $this->resource;
    $this->publicationNotesComponent->execute($this->request, $options = array('type' => 'isadPublicationNotes'));

    $this->notesComponent = new InformationObjectNotesComponent($this->context, 'informationobject', 'notes');
    $this->notesComponent->resource = $this->resource;
    $this->notesComponent->execute($this->request, $options = array('type' => 'isadNotes'));

    $this->archivistsNotesComponent = new InformationObjectNotesComponent($this->context, 'informationobject', 'notes');
    $this->archivistsNotesComponent->resource = $this->resource;
    $this->archivistsNotesComponent->execute($this->request, $options = array('type' => 'isadArchivistsNotes'));
  }

  protected function addField($name)
  {
    switch ($name)
    {
      case 'creators':
        $criteria = new Criteria;
        $this->resource->addEventsCriteria($criteria);
        $criteria->add(QubitEvent::ACTOR_ID, null, Criteria::ISNOTNULL);
        $criteria->add(QubitEvent::TYPE_ID, QubitTerm::CREATION_ID);

        $value = $choices = array();
        foreach ($this->events = QubitEvent::get($criteria) as $item)
        {
          $choices[$value[] = $this->context->routing->generate(null, array($item->actor, 'module' => 'actor'))] = $item->actor;
        }

        $this->form->setDefault('creators', $value);
        $this->form->setValidator('creators', new sfValidatorPass);
        $this->form->setWidget('creators', new sfWidgetFormSelect(array('choices' => $choices, 'multiple' => true)));

        break;

      case 'appraisal':
        $this->form->setDefault('appraisal', $this->resource['appraisal']);
        $this->form->setValidator('appraisal', new sfValidatorString);
        $this->form->setWidget('appraisal', new sfWidgetFormTextarea);

        break;

      case 'languageNotes':

        $this->form->setDefault('languageNotes', $this->isad['languageNotes']);
        $this->form->setValidator('languageNotes', new sfValidatorString);
        $this->form->setWidget('languageNotes', new sfWidgetFormTextarea);

        break;
//Bernhard 11.06.2014
      case 'signatur_b':
      case 'titel_b':
      case 'datum_entstehungszeitraum_b':
      case 'datum_entstehungszeitraum_von_b':
      case 'datum_entstehungszeitraum_bis_b':
      case 'beschreibungsebene_b':
      case 'umfang_und_materialitaet_b':
      case 'name_der_institution_meister_b':
      case 'herkunft_externer_akten_b':
      case 'letzter_eigentuemer_der_akten_b':
      case 'umfang_und_inhalt_b':
      case 'zugangsbestimmungen_GlobalEintragen_b':
      case 'reproduktionsbestimmungen_GlobalEintragen_b':
      case 'sprache_des_schriftstuecks_b':
      case 'verwandte_verzeichnungseinheiten_b':
      case 'veroeffentlichungen_sekundaerliteratur_b':
      case 'oeffentliche_bemerkung_b':
      case 'bearbeitering_bearbeitungsdatum_KlarName_b':
      case 'verzeichnungsdatum_b':
      case 'interne_bemerkung_b':
      case 'publikationsstatus_entwurf_oder_veroeffentlicht_b':
      case 'ggf_weitere_projektspezifische_felder_wie_Ort_Absender_Empfaenger_Betreff_b':

        $this->form->setDefault($name, $this->isad[$name]);
        $this->form->setValidator($name, new sfValidatorString);
        $this->form->setWidget($name, new sfWidgetFormInput);

        break;
// /Bernhard 11.06.2014
      default:

        return parent::addField($name);
    }
  }

  protected function processField($field)
  {
    switch ($field->getName())
    {
      case 'creators':
        $value = $filtered = array();
        foreach ($this->form->getValue('creators') as $item)
        {
          $params = $this->context->routing->parse(Qubit::pathInfo($item));
          $resource = $params['_sf_route']->resource;
          $value[$resource->id] = $filtered[$resource->id] = $resource;
        }

        foreach ($this->events as $item)
        {
          if (isset($value[$item->actor->id]))
          {
            unset($filtered[$item->actor->id]);
          }
          else if (!isset($this->request->sourceId))
          {
            $item->delete();
          }
        }

        foreach ($filtered as $item)
        {
          $event = new QubitEvent;
          $event->actor = $item;
          $event->typeId = QubitTerm::CREATION_ID;

          $this->resource->events[] = $event;
        }

        break;

      case 'languageNotes':

        $this->isad['languageNotes'] = $this->form->getValue('languageNotes');

        break;
//Bernhard 11.06.2014
      case 'signatur_b':
      case 'titel_b':
      case 'datum_entstehungszeitraum_b':
      case 'datum_entstehungszeitraum_von_b':
      case 'datum_entstehungszeitraum_bis_b':
      case 'beschreibungsebene_b':
      case 'umfang_und_materialitaet_b':
      case 'name_der_institution_meister_b':
      case 'herkunft_externer_akten_b':
      case 'letzter_eigentuemer_der_akten_b':
      case 'umfang_und_inhalt_b':
      case 'zugangsbestimmungen_GlobalEintragen_b':
      case 'reproduktionsbestimmungen_GlobalEintragen_b':
      case 'sprache_des_schriftstuecks_b':
      case 'verwandte_verzeichnungseinheiten_b':
      case 'veroeffentlichungen_sekundaerliteratur_b':
      case 'oeffentliche_bemerkung_b':
      case 'bearbeitering_bearbeitungsdatum_KlarName_b':
      case 'verzeichnungsdatum_b':
      case 'interne_bemerkung_b':
      case 'publikationsstatus_entwurf_oder_veroeffentlicht_b':
      case 'ggf_weitere_projektspezifische_felder_wie_Ort_Absender_Empfaenger_Betreff_b':

        $this->isad[$field->getName()] = $this->form->getValue($field->getName());
     //   $testvalue = $this->form->getValue($field->getName());

        break;

// /Bernhard 11.06.2014

      default:

        return parent::processField($field);
    }
  }

  protected function processForm()
  {
    $this->resource->sourceStandard = 'MEA ISAD(G) 2nd edition';

    $this->eventComponent->processForm();

    $this->rightEditComponent->processForm();

    $this->publicationNotesComponent->processForm();

    $this->notesComponent->processForm();

    $this->archivistsNotesComponent->processForm();

    return parent::processForm();
  }

  /**
   * Update ISAD notes
   *
   * @param QubitInformationObject $informationObject
   */
  protected function updateNotes()
  {
    if ($this->request->hasParameter('csvimport'))
    {
      // remap notes from parameters to request object
      if ($this->request->getParameterHolder()->has('newArchivistNote'))
      {
        $this->request->new_archivist_note = $this->request->getParameterHolder()->get('newArchivistNote');
      }

      if ($this->request->getParameterHolder()->has('newPublicationNote'))
      {
        $this->request->new_publication_note = $this->request->getParameterHolder()->get('newPublicationNote');
      }

      if ($this->request->getParameterHolder()->has('newNote'))
      {
        $this->request->new_note = $this->request->getParameterHolder()->get('newNote');
      }
    }

    // Update archivist's notes (multiple)
    foreach ((array) $this->request->new_archivist_note as $content)
    {
      if (0 < strlen($content))
      {
        $note = new QubitNote;
        $note->content = $content;
        $note->typeId = QubitTerm::ARCHIVIST_NOTE_ID;
        $note->userId = $this->context->user->getAttribute('user_id');

        $this->resource->notes[] = $note;
      }
    }

    // Update publication notes (multiple)
    foreach ((array) $this->request->new_publication_note as $content)
    {
      if (0 < strlen($content))
      {
        $note = new QubitNote;
        $note->content = $content;
        $note->typeId = QubitTerm::PUBLICATION_NOTE_ID;
        $note->userId = $this->context->user->getAttribute('user_id');

        $this->resource->notes[] = $note;
      }
    }

    // Update general notes (multiple)
    foreach ((array) $this->request->new_note as $content)
    {
      if (0 < strlen($content))
      {
        $note = new QubitNote;
        $note->content = $content;
        $note->typeId = QubitTerm::GENERAL_NOTE_ID;
        $note->userId = $this->context->user->getAttribute('user_id');

        $this->resource->notes[] = $note;
      }
    }
  }
}
