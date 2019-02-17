<?php

namespace Core\HTML;

/**
 * Class Form
 * Permet de générer un formulaire
 * @package Core\HTML
 */

class Form
{
    /**
     * @var array  Données utilisées par le formulaire
     */

    public $data;

    /**
     * @var string Tag utilisé pour entourer les champs
     */

    public $surround ='p';

    /**
     * Form constructor.
     * @param array $data
     */


    public function __construct($data = array())
    {

        $this->data = $data;

    }

    /**
     * Code HTML à entourer
     * @param $html
     * @return string
     */

    protected function surround($html){

        return "<{$this->surround}>{$html}</{$this->surround}>";

    }

    /**
     * @param $index
     * @return mixed|null
     */

    protected function getValue($index){

        if(is_object($this->data)){

            return $this->data->$index;

        }

        return isset($this->data[$index]) ? $this->data[$index] : null;

    }

    /**
     * @param $name
     * @param $label
     * @param array $options
     * @return string
     */

    public function input($name, $label, $options = []){

        $type = isset($options['type']) ? $options['type'] : 'text';

        return $this->surround(

            '<input type="' . $type . '" name="' . $name .'" value="' . $this->getValue($name) . '">'

        );

    }

    /**
     * Créer le bouton envoyer
     */

    public function submit(){

        return $this->surround('<button type="submit">Envoyer</button>');

    }

}