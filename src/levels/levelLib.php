<?php
class LevelLib
{
    public static function getLengthFromString($levelString) {
        try {
            require (__DIR__) . "/../lib/utils.php";
            $raw_level = explode(";", gzdecode(Utils::Base64url_decode($levelString))); 
            
            $starting_speed = explode(",", $raw_level[0])[27];

            $max_x_pos = 0;
            $portals = [201, 200, 202, 203, 1334];
            $speed_portals = [[$starting_speed, 0]];

            for ($i = 1; $i < count($raw_level); $i++) { 
                // echo $raw_level[$i] . "<br>";
                $object = explode(',', $raw_level[$i]);

                if ($object[3] > $max_x_pos)
                    $max_x_pos = $object[3];

                if (in_array($object[1], $portals)) {
                    array_push($speed_portals, [array_search($object[1], $portals), $object[3]]);
                }
            }

            array_push($speed_portals, [0, $max_x_pos]);

            $units_per_second = [311.58, 251.16, 387.42, 468.00, 576.00];

            $seconds = 0.0;
            $lastElement = [0, 0];

            for ($i = 0; $i < count($speed_portals); $i++) { 
                $element = $speed_portals[$i];

                if ($i == 0) {
                    $lastElement = $element;
                    continue;
                }

                $seconds += ($element[1] - $lastElement[1]) / $units_per_second[$lastElement[0]];

                $lastElement = $element;
            }

            return $seconds;

        } catch (Exception $exception) {
            return false;
        }
    }

}

class Difficulty {
    // todo: remove this, this is horrid
    public static $nameKeys = [-3 => "Auto", -2 => "Demon", -1 => "NA", 1 => "Easy", "Medium", "Hard", "Harder", "Insane"];
    public static $numKeys = ["Auto" => -3, "Demon" => -2, "NA" => -1, "Easy" => 1, "Medium" => 2, "Hard" => 3, "Harder" => 4, "Insane" => 5];
    public static $demonNameKeys = [3 => "Easy", 4 => "Medium", 0 => "Hard", 5 => "Insane", 6 => "Extreme"];
    public static $demonFilterNameKeys = [1 => "Easy", 2 => "Medium", 3 => "Hard", 4 => "Insane", 5 => "Extreme"];
    public static $demonNumKeys = ["Easy" => 3, "Medium" => 4, "Hard" => 0, "Insane" => 5, "Extreme" => 6];
}