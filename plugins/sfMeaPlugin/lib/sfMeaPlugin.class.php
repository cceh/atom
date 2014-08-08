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
 * This class is used to provide methods that supplement the core Qubit
 * information object with behaviour or presentation features that are specific
 * to the ICA's International Standard Archival Description (ISAD)
 *
 * @package    AccesstoMemory
 * @author     Peter Van Garderen <peter@artefactual.com>
 */

class sfMeaPlugin implements ArrayAccess
{
  protected
    $resource;

//Bernhard 11.06.2014 Vgl. sfRadPlugin
  protected
    $property;
// /Bernhard 11.06.2014

  public function __construct(QubitInformationObject $resource)
  {
    $this->resource = $resource;
  }

  public function __toString()
  {
    $string = array();

    $levelOfDescriptionAndIdentifier = array();

    if (isset($this->resource->levelOfDescription))
    {
      $levelOfDescriptionAndIdentifier[] = $this->resource->levelOfDescription->__toString();
    }

    if (isset($this->resource->identifier))
    {
      $levelOfDescriptionAndIdentifier[] = $this->resource->identifier;
    }

    if (0 < count($levelOfDescriptionAndIdentifier))
    {
      $string[] = implode($levelOfDescriptionAndIdentifier, ' ');
    }

    $titleAndPublicationStatus = array();

    if (0 < strlen($title = $this->resource->__toString()))
    {
      $titleAndPublicationStatus[] = $title;
    }

    $publicationStatus = $this->resource->getPublicationStatus();
    if (isset($publicationStatus) && QubitTerm::PUBLICATION_STATUS_DRAFT_ID == $publicationStatus->statusId)
    {
      $titleAndPublicationStatus[] = "({$publicationStatus->status->__toString()})";
    }

    if (0 < count($titleAndPublicationStatus))
    {
      $string[] = implode($titleAndPublicationStatus, ' ');
    }

    return implode(' - ', $string);
  }

  public function __get($name)
  {
//Bernhard 11.06.2014 vgl. sfRagPlugin
    $args = func_get_args();

    $options = array();
    if (1 < count($args))
    {
      $options = $args[1];
    }
// /Bernhard 11.06.2014

    switch ($name)
    {
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

        return $this->property($name)->__get('value', $options);

// /Bernhard 11.06.2014
      case 'languageNotes':

        return $this->resource->getNotesByType(array('noteTypeId' => QubitTerm::LANGUAGE_NOTE_ID))->offsetGet(0);

      case 'referenceCode':

        return $this->resource->referenceCode;

      case 'sourceCulture':

        return $this->resource->sourceCulture;
    }
  }

  public function __set($name, $value)
  {
    switch ($name)
    {
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

        $this->property($name)->value = $value;

        return $this;

// /Bernhard 11.06.2014

      case 'languageNotes':

        // Stop if the string is empty
        if (0 == strlen($value))
        {
          break;
        }

        if (0 == count($note = $this->resource->getNotesByType(array('noteTypeId' => QubitTerm::LANGUAGE_NOTE_ID))->offsetGet(0)))
        {
          $note = new QubitNote;
          $note->typeId = QubitTerm::LANGUAGE_NOTE_ID;
          $note->userId = sfContext::getInstance()->user->getAttribute('user_id');

          $this->resource->notes[] = $note;
        }

        $note->content = $value;

        return $this;
    }
  }

// Bernhard 11.06.2014

  protected function property($name)
  {
    if (!isset($this->property[$name]))
    {
      $criteria = new Criteria;
      $this->resource->addPropertysCriteria($criteria);
      $criteria->add(QubitProperty::NAME, $name);

      if (1 == count($query = QubitProperty::get($criteria)))
      {
        $this->property[$name] = $query[0];
      }
      else
      {
        $this->property[$name] = new QubitProperty;
        $this->property[$name]->name = $name;

        $this->resource->propertys[] = $this->property[$name];
      }
    }

    return $this->property[$name];
  }


// /Bernhard 11.06.2014

  public function offsetExists($offset)
  {
    $args = func_get_args();

    return call_user_func_array(array($this, '__isset'), $args);
  }

  public function offsetGet($offset)
  {
    $args = func_get_args();

    return call_user_func_array(array($this, '__get'), $args);
  }

  public function offsetSet($offset, $value)
  {
    $args = func_get_args();

    return call_user_func_array(array($this, '__set'), $args);
  }

  public function offsetUnset($offset)
  {
    $args = func_get_args();

    return call_user_func_array(array($this, '__unset'), $args);
  }

  public static function eventTypes()
  {
    return array(QubitTerm::getById(QubitTerm::CREATION_ID),
      QubitTerm::getById(QubitTerm::ACCUMULATION_ID));
  }
}
