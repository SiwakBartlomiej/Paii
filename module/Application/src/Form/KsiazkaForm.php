<?php

namespace Application\Form;

use Application\Model\Autor;
use Laminas\Form\Form;
use Laminas\I18n\Validator\IsFloat;
use Laminas\InputFilter\InputFilterProviderInterface;

class KsiazkaForm extends Form implements InputFilterProviderInterface
{
    public function __construct(Autor $autor)
    {
        parent::__construct('ksiazka');

        $this->setAttributes(['method' => 'post', 'class' => 'form']);
        $this->add([
            'name' => 'tytul',
            'type' => 'Text',
            'options' => [
                'label' => 'Tytuł',
            ],
            'attributes' => ['class' => 'form-control'],
        ]);
        $this->add([
            'name' => 'id_autora',
            'type' => 'Select',
            'options' => [
                'label' => 'Autor',
                'value_options' => $autor->pobierzSlownik(),
            ],
            'attributes' => ['class' => 'form-control'],
        ]);
        $this->add([
            'name' => 'cena',
            'type' => 'Text',
            'options' => [
                'label' => 'Cena',
            ],
            'attributes' => ['class' => 'form-control'],
        ]);
        $this->add([
            'name' => 'liczba_stron',
            'type' => 'Text',
            'options' => [
                'label' => 'Liczba stron',
            ],
            'attributes' => ['class' => 'form-control'],
        ]);
        $this->add([
            'name' => 'opis',
            'type' => 'Textarea',
            'options' => [
                'label' => 'Opis',
            ],
            'attributes' => ['class' => 'form-control'],
        ]);
        $this->add([
            'name' => 'zapisz',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Zapisz',
                'class' => 'btn btn-primary',
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            [
                'name' => 'tytul',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [],
            ],
            [
                'name' => 'id_autora',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [],
            ],
            [
                'name' => 'cena',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    new IsFloat(['locale' => 'en']),
                    ['name' => 'GreaterThan', 'options' => ['min' => 0]],
                ],
            ],
            [
                'name' => 'liczba_stron',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    ['name' => 'Digits'],
                    ['name' => 'GreaterThan', 'options' => ['min' => 0]],
                ],
            ],
            [
                'name' => 'opis',
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [],
            ],
        ];
    }
}