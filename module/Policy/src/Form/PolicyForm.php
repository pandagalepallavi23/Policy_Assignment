<?php
namespace Policy\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;

class PolicyForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('policy');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'firstname',
            'type' => 'text',
            'options' => [
                'label' => 'First Name',
            ],
        ]);
        $this->add([
            'name' => 'lastname',
            'type' => 'text',
            'options' => [
                'label' => 'Last Name',
            ],
        ]);
        $this->add([
            'type' => Element\Date::class,
            'name' => 'start_date',
            'options' => [
                'label' => 'Start Date',
                'format' => 'Y-m-d',
            ],
            'attributes' => [
                'min' => '2022-10-01',
                'max' => '2022-12-01',
                'step' => '1', // days; default step interval is 1 day
            ],
        ]);
        $this->add([
            'type' => Element\Date::class,
            'name' => 'end_date',
            'options' => [
                'label' => 'End Date',
                'format' => 'Y-m-d',
            ],
            'attributes' => [
                'min' => '2022-10-01',
                'max' => '2062-12-01',
                'step' => '1', // days; default step interval is 1 day
            ],
        ]);
        $this->add([
            'name' => 'policy_number',
            'type' => 'text',
            'options' => [
                'label' => 'Policy Number',
            ],
        ]);
        $this->add([
            'name' => 'premium',
            'type' => 'text',
            'options' => [
                'label' => 'Premium Amount in Rs.',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }


}