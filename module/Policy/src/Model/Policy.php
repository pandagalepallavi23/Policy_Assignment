<?php
    namespace Policy\Model;

    use DomainException;
    use Laminas\Filter\StringTrim;
    use Laminas\Filter\DateSelect;
    use Laminas\Filter\StripTags;
    use Laminas\Filter\ToInt;
    use Laminas\Filter\ToFloat;
    use Laminas\InputFilter\InputFilter;
    use Laminas\InputFilter\InputFilterAwareInterface;
    use Laminas\InputFilter\InputFilterInterface;
    use Laminas\Validator\StringLength;
    use Laminas\Validator\Date;
    use Laminas\Validator\DateStep;
    use Laminas\InputFilter\Input;
    use Laminas\Validator;
    use Laminas\Validator\EndDateValidator;

    class Policy implements InputFilterAwareInterface
    {
        public $id;
        public $firstname;
        public $lastname;
        public $start_date;
        public $end_date;
        public $policy_number;
        public $premium;

        private $inputFilter;

        public function exchangeArray(array $data)
        {
            $this->id     = !empty($data['id']) ? $data['id'] : null;
            $this->firstname = !empty($data['firstname']) ? $data['firstname'] : null;
            $this->lastname  = !empty($data['lastname']) ? $data['lastname'] : null;
            $this->start_date  = !empty($data['start_date']) ? $data['start_date'] : null;
            $this->end_date  = !empty($data['end_date']) ? $data['end_date'] : null;
            $this->policy_number  = !empty($data['policy_number']) ? $data['policy_number'] : null;
            $this->premium  = !empty($data['premium']) ? $data['premium'] : 0.0;
        }

        public function setInputFilter(InputFilterInterface $inputFilter)
        {
            throw new DomainException(sprintf(
                '%s does not allow injection of an alternate input filter',
                __CLASS__
            ));
        }

        public function getInputFilter()
        {
                if ($this->inputFilter) {
                    return $this->inputFilter;
                }

                //Need some changes to convert date into string to use in the EndDateValidator.

                /*$start_date = new Input('start_date');
                $end_date = new Input('end_date');
                $end_date->getValidatorChain()
                ->attach(new EndDateValidator(new Validator\Date($start_date), new Validator\Date($end_date) ));
                */
                $inputFilter = new InputFilter();
                
                /*$inputFilter->add($start_date);
                $inputFilter->add($end_date);
                $inputFilter->setData($_POST);*/
                
               // $inputFilter = new InputFilter();
                $inputFilter->add([
                    'name' => 'id',
                    'required' => true,
                    'filters' => [
                        ['name' => ToInt::class],
                    ],
                ]);

                $inputFilter->add([
                    'name' => 'firstname',
                    'required' => false,
                    'filters' => [
                        ['name' => StripTags::class],
                        ['name' => StringTrim::class],
                    ],
                    'validators' => [
                        [
                            'name' => StringLength::class,
                            'options' => [
                                'encoding' => 'UTF-8',
                                'min' => 1,
                                'max' => 100,
                            ],
                        ],
                    ],
                ]);

                $inputFilter->add([
                    'name' => 'lastname',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class],
                        ['name' => StringTrim::class],
                    ],
                    'validators' => [
                        [
                            'name' => StringLength::class,
                            'options' => [
                                'encoding' => 'UTF-8',
                                'min' => 1,
                                'max' => 100,
                            ],
                        ],
                    ],
                ]);

                $inputFilter->add([
                    'name' => 'start_date',
                    'required' => true,
                    'filters' => [
                        ['name' => DateSelect::class],
                    ],
                    'validators' => [
                        [
                            'name' => Date::class,
                            'options' => [
                                'encoding' => 'UTF-8',
                                'min' => '2022-10-01',
                                'max' => '2022-12-01',
                            ],
                        ],
                    ],
                ]);

                $inputFilter->add([
                    'name' => 'end_date',
                    'required' => true,
                    'filters' => [
                        ['name' => DateSelect::class],
                    ],
                    'validators' => [
                        [
                            'name' => Date::class,
                            'options' => [
                                'encoding' => 'UTF-8',
                                'min' => '2022-10-01',
                                'max' => '2062-12-01',
                            ],
                        ],
                    ],
                ]);

                $inputFilter->add([
                    'name' => 'policy_number',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class],
                        ['name' => StringTrim::class],
                    ],
                    'validators' => [
                        [
                            'name' => StringLength::class,
                            'options' => [
                                'encoding' => 'UTF-8',
                                'min' => 1,
                                'max' => 25,
                            ],
                        ],
                    ],
                ]);

                $inputFilter->add([
                    'name' => 'premium',
                    'required' => false,
                    'filters' => [
                        ['name' => StripTags::class],
                        ['name' => StringTrim::class],
                        ['name' => ToFloat::class],
                    ]
                ]);

                $this->inputFilter = $inputFilter;
                return $this->inputFilter;
            }

        public function getArrayCopy()
        {
            return [
                'id'     => $this->id,
                'firstname' => $this->firstname,
                'lastname'  => $this->lastname,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'policy_number' => $this->policy_number,
                'premium' => $this->premium
            ];
        }

    }

        