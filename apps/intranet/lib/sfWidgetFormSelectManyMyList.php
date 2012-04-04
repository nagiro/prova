<?php

/**
 * Aquesta classe és per emmagatzemar el resultat d'una listbox amb una llista segmentada per @
 * @author Albert Johé. 
 * */
class sfWidgetFormSelectManyMyList extends sfWidgetFormSelect
{

  /**
   * Returns an array of option tags for the given choices
   *
   * @param  string $value    The selected value
   * @param  array  $choices  An array of choices
   *
   * @return array  An array of option tags
   */
  protected function getOptionsForSelect($value, $choices)
  {
    $mainAttributes = $this->attributes;
    $this->attributes = array();

    $value = explode('@',$value);            
    $value = array_map('strval', array_values($value));
    $value_set = array_flip($value);

    $options = array();
    foreach ($choices as $key => $option)
    {
      if (is_array($option))
      {
        $options[] = $this->renderContentTag('optgroup', implode("\n", $this->getOptionsForSelect($value, $option)), array('label' => self::escapeOnce($key)));
      }
      else
      {
        $attributes = array('value' => self::escapeOnce($key));
        if (isset($value_set[strval($key)]))
        {
          $attributes['selected'] = 'selected';
        }

        $options[] = $this->renderContentTag('option', self::escapeOnce($option), $attributes);
      }
    }

    $this->attributes = $mainAttributes;

    return $options;
  }  
  
}
