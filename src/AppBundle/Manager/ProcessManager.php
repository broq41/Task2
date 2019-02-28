<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Person;
use AppBundle\Repository\PersonRepository;


class ProcessManager
{

    /**
     * @var PersonRepository
     */
    private $personRepository;

    /**
     * ProcessManager constructor.
     * @param PersonRepository $personRepository
     */
    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;

    }

    /**
     * @param $handle
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function processCSV($handle)
    {
        $row = 0;

        while (($data = fgetcsv($handle, 3000, ",")) !== FALSE) {

            if (empty($data[0])) {
                exit;
            }

            if ($row === 0) {

                $countryIndex = array_search('country', $data);

                $row++;
                continue;
            }

            if (!empty($countryIndex)) {

                $country = $data[$countryIndex];
                if (!empty($people[$country])) {
                    $people[$country]++;

                } else {
                    $people[$country] = 1;
                }
            }

            $row++;
        }

        if (!empty($people)) {

            foreach ($people as $country => $counter) {

                if ($country) {

                    $person = $this->personRepository->findByCountry($country);

                    if (!$person) {

                        $person = new Person();
                        $person->setCountry($country);
                        $person->setCount($counter);

                    } else {

                        $oldCount = $person->getCount();
                        $newCount = $counter + $oldCount;
                        $person->setCount($newCount);

                    }

                    if ($person) {
                        $this->personRepository->save($person);
                        unset($person);
                    }

                }
            }
        }

        fclose($handle);
        return true;

    }


}