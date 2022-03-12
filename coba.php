<?php


class Parameter
{
    const file_name = 'cocomo_nasa93.txt';
    const mr = 0.01;
    const populationSize = 30;
    const crossoverRate = 0.9;
}

class CocomoNasa93Processor
{
    public function processingData()
    {
        $raw_dataset = file(Parameter::file_name);
        foreach ($raw_dataset as $val) {
            $data[] = explode(",", $val);
        }

        $columnIndexes = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25];
        $columns = ['prec', 'flex', 'resl', 'team', 'pmat', 'rely', 'data', 'cplx', 'ruse', 'docu', 'time', 'stor', 'pvol', 'acap', 'pcap', 'pcon', 'apex', 'plex', 'ltex', 'tool', 'site', 'sced', 'kloc', 'actualEffort', 'defects', 'months'];
        foreach ($data as $key => $val) {
            foreach (array_keys($val) as $subkey) {
                if ($subkey == $columnIndexes[$subkey]) {
                    $data[$key][$columns[$subkey]] = $data[$key][$subkey];
                    unset($data[$key][$subkey]);
                }
            }
        }
        return $data;
    }

    function getScales()
    {
        return array(
            "prec" => array("vl" => 6.2, "l" => 4.96, "n" => 3.72, "h" => 2.48, "vh" => 1.24, "eh" => 0),
            "flex" => array("vl" => 5.07, "l" => 4.05, "n" => 3.04, "h" => 2.03, "vh" => 1.01, "eh" => 0),
            "resl" => array("vl" => 7.07, "l" => 5.65, "n" => 4.24, "h" => 2.83, "vh" => 1.41, "eh" => 0),
            "team" => array("vl" => 5.48, "l" => 4.38, "n" => 3.29, "h" => 2.19, "vh" => 1.10, "eh" => 0),
            "pmat" => array("vl" => 7.80, "l" => 6.24, "n" => 4.68, "h" => 3.12, "vh" => 1.56, "eh" => 0),
            "rely" => array("vl" => 0.82, "l" => 0.92, "n" => 1.00, "h" => 1.10, "vh" => 1.26, "eh" => ''),
            "data" => array("vl" => '', "l" => 0.90, "n" => 1.00, "h" => 1.14, "vh" => 1.28, "eh" => ''),
            "cplx" => array("vl" => 0.73, "l" => 0.87, "n" => 1.00, "h" => 1.17, "vh" => 1.34, "eh" => 1.74),
            "ruse" => array("vl" => '', "l" => 0.95, "n" => 1.00, "h" => 1.07, "vh" => 1.15, "eh" => 1.24),
            "docu" => array("vl" => 0.81, "l" => 0.91, "n" => 1.00, "h" => 1.11, "vh" => 1.23, "eh" => ''),
            "time" => array("vl" => '', "l" => '', "n" => 1.00, "h" => 1.11, "vh" => 1.29, "eh" => 1.63),
            "stor" => array("vl" => '', "l" => '', "n" => 1.00, "h" => 1.05, "vh" => 1.17, "eh" => 1.46),
            "pvol" => array("vl" => '', "l" => 0.87, "n" => 1.00, "h" => 1.15, "vh" => 1.30, "eh" => ''),
            "acap" => array("vl" => 1.42, "l" => 1.19, "n" => 1.00, "h" => 0.85, "vh" => 0.71, "eh" => ''),
            "pcap" => array("vl" => 1.34, "l" => 1.15, "n" => 1.00, "h" => 0.88, "vh" => 0.76, "eh" => ''),
            "pcon" => array("vl" => 1.29, "l" => 1.12, "n" => 1.00, "h" => 0.90, "vh" => 0.81, "eh" => ''),
            "apex" => array("vl" => 1.22, "l" => 1.10, "n" => 1.00, "h" => 0.88, "vh" => 0.81, "eh" => ''),
            "plex" => array("vl" => 1.19, "l" => 1.09, "n" => 1.00, "h" => 0.91, "vh" => 0.85, "eh" => ''),
            "ltex" => array("vl" => 1.20, "l" => 1.09, "n" => 1.00, "h" => 0.91, "vh" => 0.84, "eh" => ''),
            "tool" => array("vl" => 1.17, "l" => 1.09, "n" => 1.00, "h" => 0.90, "vh" => 0.78, "eh" => ''),
            "site" => array("vl" => 1.22, "l" => 1.09, "n" => 1.00, "h" => 0.93, "vh" => 0.86, "eh" => 0.80),
            "sced" => array("vl" => 1.43, "l" => 1.14, "n" => 1.00, "h" => 1.00, "vh" => 1.00, "eh" => '')
        );
    }


    function putScales()
    {
        $project = $this->processingData();
        $scales = $this->getScales();

        foreach ($project as $key => $val) {
            foreach (array_keys($val) as $subkey => $subval) {
                if ($subkey < sizeof($scales)) {
                    $key_subproject = array_keys($val);
                    $key_scales = array_keys($scales);
                    if ($key_subproject[$subkey] == $key_scales[$subkey]) {
                        $search = $val[$key_subproject[$subkey]];
                        if (key_exists($search, $scales[$key_scales[$subkey]])) {
                            $subkey_scales = $scales[$key_scales[$subkey]];
                            $project[$key][$key_subproject[$subkey]] =  $subkey_scales[$search];
                        }
                    }
                }
            }
        }
        return $project;
    }
}

class Individu
{
    function createIndividu()
    {
        return [
            'A' => mt_rand(0 * 100, 10 * 100) / 100,
            'B' => mt_rand(0.3 * 100, 2 * 100) / 100
        ];
    }

    function countNumberOfGen()
    {
        return count($this->createIndividu());
    }
}

class Population
{

    function createPopulation()
    {
        $individu = new Individu;
        for ($i = 0; $i < Parameter::populationSize; $i++) {
            $population[$i] = $individu->createIndividu();
        }

        return $population;
    }
}

class COCOMO93
{

    function __construct($project, $population)
    {
        $this->project = $project;
        $this->population = $population;
    }


    function ScaleFactor()
    {
        $columSF = ["prec", "flex", "resl", "team", "pmat"];

        foreach ($this->project as $key => $val) {
            foreach (array_keys($val) as $subkey => $val_subkey) {
                if ($subkey < sizeof($columSF)) {
                    $sf[$subkey] =  $val[$val_subkey];
                }
            }
            $ScaleFactor[$key] = $sf;
        }
        return $ScaleFactor;
    }

    function EffortMultipyer()
    {
        $project = $this->project;
        $columEM = ["rely", "data", "cplx", "ruse", "docu", "time", "stor", "pvol", "acap", "pcap", "pcon", "apex", "plex", "ltex", "tool", "site", "sced"];

        foreach ($project as $key => $val) {
            foreach (array_keys($val) as $subkey => $val_subkey) {
                if ($subkey < 17) {
                    if ($val_subkey  = $columEM[$subkey]) {
                        $em[$subkey] = $val[$val_subkey];
                    }
                }
            }
            $array_EM[$key] = $em;
        }
        return $array_EM;
    }

    function scaleEffortExponent($B, $scale_factors)
    {
        return floatval($B)  + 0.01 * array_sum($scale_factors);
    }

    function estimating($A, $size, $E, $effort_multipliers)
    {
        return floatval($A)  * pow($size, $E) * array_product($effort_multipliers);
    }


    function PersonMounth()
    {
        $ScaleFactor = $this->ScaleFactor();
        $EffortMultiplyer = $this->EffortMultipyer();
        $population = $this->population;
        $project = $this->project;

        foreach ($project as $key => $val) {

            //  for ($i = 0; $i <= 10; $i++) {

            foreach ($population as $key_population => $val_population) {
                $E = $this->scaleEffortExponent($val_population['B'], $ScaleFactor[$key]);
                $PM = $this->estimating($val_population['A'], $val['kloc'], $E, $EffortMultiplyer[$key]);
                $individu[$key_population] = [
                    'A' => $val_population['A'],
                    'B' => $val_population['B'],
                    'PM' => $PM,
                    'months' => $val['months'],
                ];
            }
            $POP[$key] = $individu;
            // }

        }
        return  $POP;
    }
}

class Fitness
{
    function __construct($population)
    {
        $this->population = $population;
    }
    function RelativeError($estimasiPM, $actualPM)
    {
        return floatval($estimasiPM - $actualPM);
    }

    function sumFitnessvalue($fitnessValue)
    {
        return floatval(array_sum($fitnessValue));
    }

    function fitnessEvaluation()
    {
        foreach ($this->population as $key => $val) {
            //  print_r('Projek ' . $key . ' ');
            foreach ($val as $key_individu => $val_individu) {
                //    echo '<br>';

                $fitnessIndividu[$key_individu] = [
                    'A' => $val_individu['A'],
                    'B' => $val_individu['B'],
                    'PM' => $val_individu['PM'],
                    'months' => $val_individu['months'],
                    'fitness' => $this->RelativeError(floatval($val_individu['PM']), floatval($val_individu['months']))
                ];

                $fitnessValue[$key_individu] = $fitnessIndividu[$key_individu]['fitness'];
                // print_r($fitnessIndividu[$key_individu]);
            }
            $fitness_project[$key] = $fitnessValue;
            // echo '<br>';
            // echo 'total Fitness ';
            $fitnessTotal[$key] = $this->sumFitnessvalue($fitness_project[$key]);
            //  print_r($fitnessTotal[$key]);

            $fitnessEvaluation[$key] = [
                'populasi' =>  $fitnessIndividu,
                'totalFitness' => $fitnessTotal
            ];

            //echo '<p>';
        }
        return $fitnessEvaluation;
    }

    function countProbability($fitness, $total)
    {
        return floatval($fitness / $total);
    }

    function probability()
    {
        foreach ($this->fitnessEvaluation() as $key => $val) {
            // print_r('Project ' . $key . '');
            foreach ($val['populasi'] as  $key_individu => $val_individu) {
                // echo '<br>';
                // print_r($key_individu . '- ');
                $probabilityIndividu[$key_individu] = [
                    'probability' => $this->countProbability(floatval($val_individu['fitness']), floatval($val['totalFitness'][$key])),
                    'A' => $val_individu['A'],
                    'B' => $val_individu['B'],
                    'PM' => $val_individu['PM'],
                    'months' => $val_individu['months'],
                    'fitness' => $val_individu['fitness'],
                    'totalFitess' => $val['totalFitness'][$key]
                ];
            }
            // echo '<br>';
            // echo 'Total Fitness';
            // print_r($val['totalFitness'][$key]);
            $populasi[$key] = $probabilityIndividu;
            // asort($probabilityIndividu);
            // echo '<p>';
        }
        return $populasi;
    }

    function comulativeProbability()
    {
        foreach ($this->probability() as $key => $val) {
            print_r('Project ' . $key . '');
            $temp = 0;
            foreach ($val as $key_individu => $val_individu) {
                echo '<br>';
                if ($key_individu == 0) {
                    $temp = abs($val_individu['probability'] + 0);
                    $probabilityKomulatif[$key_individu] = [
                        'komulatif' =>   $temp,
                        'probability' => $val_individu['probability'],
                        'A' => $val_individu['A'],
                        'B' => $val_individu['B'],
                        'PM' => $val_individu['PM'],
                        'months' => $val_individu['months'],
                        'fitness' => $val_individu['fitness'],
                        'totalFitess' => $val_individu['totalFitess'],
                    ];
                } else {
                    $temp += abs($val_individu['probability']);
                    $probabilityKomulatif[$key_individu] = [
                        'komulatif' => $temp,
                        'probability' => $val_individu['probability'],
                        'A' => $val_individu['A'],
                        'B' => $val_individu['B'],
                        'PM' => $val_individu['PM'],
                        'months' => $val_individu['months'],
                        'fitness' => $val_individu['fitness'],
                        'totalFitess' => $val_individu['totalFitess'],
                    ];
                }
                print_r($probabilityKomulatif[$key_individu]);
            }
            asort($probabilityKomulatif);
            //  $populasi[$key] = $probabilityKomulatif;

            echo '<p>';
        }
        //  return $populasi;
    }

    // function cek()
    // {
    //     foreach ($this->comulativeProbability() as $key => $val) {
    //         print_r('Project ' . $key);
    //         foreach ($val as $key_individu => $val_individu) {
    //             echo '<br>';
    //             print_r($val_individu);
    //         }
    //         echo '<p>';
    //     }
    // }
}



// class Crossover
// {
//     function __construct($population, $crossoverRate)
//     {
//         $this->population = $population;
//         $this->crossoverRate = $crossoverRate;
//     }


//     function cutPointIndex()
//     {
//         $lengthOfGen = new Individu;
//         return rand(0, $lengthOfGen->countNumberOfGen() - 1);
//     }

//     function randomZeroToOne()
//     {
//         return (float) rand() / (float) getrandmax();
//     }

//     function hasParents($population, $crossoverRate)
//     {
//         for ($i = 0; $i <= count($population) - 1; $i++) {
//             $randomZeroToOne = $this->randomZeroToOne();
//             if ($randomZeroToOne < $crossoverRate) {
//                 $parents[$i] = $randomZeroToOne;
//             }
//         }
//         return $parents;
//     }



//     function generateCrossover($population, $crossoverRate)
//     {
//         $ret = [];
//         $count = 0;
//         $parents = $this->hasParents($population, $crossoverRate);
//         while ($count < 1 && count($parents) === 0) {
//             $parents = $this->hasParents($population, $crossoverRate);
//             if (count($parents) > 0) {
//                 break;
//             }
//             $count = 0;
//         }
//         foreach (array_keys($parents) as $key) {
//             $keys[] = $key;
//         }
//         foreach ($keys as $key => $val) {
//             // print_r($val);
//             // echo '<br>';
//             foreach ($keys as $subval) {
//                 // print_r($subval);
//                 // echo '<br>';
//                 if ($val !== $subval) {
//                     $ret[] = [$val, $subval];
//                 }
//             }
//             array_shift($keys);
//         }
//         return $ret;
//     }

//     function isMaxIndex($cutPointIndex, $lengthOfChromosome)
//     {
//         if ($cutPointIndex === $lengthOfChromosome - 1) {
//             return TRUE;
//         }
//     }

//     function offspring($parent1, $parent2, $cutPointIndex, $offspring, $lengthOfChromosome)
//     {
//         $ret = [];
//         ## TODO refaktor tenanan bro!
//         if ($offspring === 1) {
//             if ($this->isMaxIndex($cutPointIndex, $lengthOfChromosome)) {
//                 foreach ($parent2 as $key => $val) {
//                     // print_r($val);
//                     // echo '<br>';
//                     if ($key < $cutPointIndex) {
//                         $ret[] = $val['variableValue'];
//                     }
//                 }
//                 $ret[] = $parent1[$cutPointIndex]['variableValue'];
//             } else {
//                 foreach ($parent1 as $key => $val) {
//                     if ($key <= $cutPointIndex) {
//                         $ret[] = $val['variableValue'];
//                     }
//                     if ($key > $cutPointIndex) {
//                         $ret[] = $parent2[$key]['variableValue'];
//                     }
//                 }
//             }
//         }

//         if ($offspring === 2) {
//             if ($this->isMaxIndex($cutPointIndex, $lengthOfChromosome)) {
//                 foreach ($parent1 as $key => $val) {
//                     if ($key < $cutPointIndex) {
//                         $ret[] = $val['variableValue'];
//                     }
//                 }
//                 $ret[] = $parent2[$cutPointIndex]['variableValue'];
//             } else {
//                 foreach ($parent2 as $key => $val) {
//                     if ($key <= $cutPointIndex) {
//                         $ret[] = $val['variableValue'];
//                     }
//                     if ($key > $cutPointIndex) {
//                         $ret[] = $parent1[$key]['variableValue'];
//                     }
//                 }
//             }
//         }
//         return $ret;
//     }

//     function crossover()
//     {
//         $lengthOfChromosome = (new Individu)->countNumberOfGen();
//         // $crossoverGenerator = $this->generateCrossover();
//         $parents = $this->generateCrossover($this->population, $this->crossoverRate);

//         $ret = [];
//         foreach ($parents as $parent) {
//             $cutPointIndex = $this->cutPointIndex();
//             // echo 'Cut:' . $cutPointIndex;
//             // echo '<br>';
//             // echo 'Parents: <br>';
//             // print_r($this->population[$parent[0]]);
//             $parent1 = $this->population[$parent[0]];
//             // print_r($parent1);
//             // echo '<br>';
//             print_r($this->population[$parent[1]]);
//             $parent2 = $this->population[$parent[1]];
//             // echo '<br>';
//             // echo 'Offspring:<br>';
//             $offspring1 = $this->offspring($parent1, $parent2, $cutPointIndex, 1, $lengthOfChromosome);
//             // $offspring2 = $this->offspring($parent1, $parent2, $cutPointIndex, 2, $lengthOfChromosome);
//             //  print_r($offspring1);
//             //echo '<br>';
//             //print_r($offspring2);
//             //echo '<p></p>';
//             // $ret[] = $offspring1;
//             // $ret[] = $offspring2;
//         }
//         // return $ret;
//     }
// }



$CocomoNasa93Processor = (new CocomoNasa93Processor);

$population = (new Population())->createPopulation();

$Cocomo = (new COCOMO93($CocomoNasa93Processor->putScales(), $population))->PersonMounth();
//print_r($Cocomo->PersonMounth());

$fitness = new Fitness($Cocomo);
print_r($fitness->comulativeProbability());

// $crossover = new Crossover($population, Parameter::crossoverRate);
// print_r($crossover->crossover());
